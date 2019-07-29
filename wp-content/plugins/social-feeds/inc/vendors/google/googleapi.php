<?php

class Googleapi
{
    public $referral = null;
    private $service;
    private $client;
    private $accessDB = false;

    public function __construct(&$ctrl) {
        $this->config = $ctrl->get('config');
        $this->model = &$ctrl->model;
        $this->cached = &$ctrl->cached;
        define('GOOGLE_API_CLIENT_ID', @$this->config->google_client_id);
        define('GOOGLE_API_CLIENT_SECRET', @$this->config->google_client_secret);
        //Requires Session Start
        require_once 'src/Google_Client.php';
        require_once 'src/contrib/Google_AnalyticsService.php';
        $this->client = new Google_Client();
        $this->client->setApplicationName("Google Analytics PHP Starter Application");
        $this->service = new Google_AnalyticsService($this->client);
        $this->client->setState('offline');
        if(defined('ENABLE_GOOGLE_TOKEN_DB') && ENABLE_GOOGLE_TOKEN_DB===true && isset($this->config->google_token))  {
            $this->accessDB = true;
        }

        if (isset($_GET['logout'])) {
            unset($_SESSION['token']);
        }
        if (isset($_GET['code'])) {
            $this->client->authenticate();
            $_SESSION['token'] = $this->client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }
        if (isset($_SESSION['token'])) {
            $this->client->setAccessToken($_SESSION['token']);
        }
    }
    public function googleConnect(){
        if (!$this->client->getAccessToken()) {
            if($this->accessDB && !empty($this->config->google_token)) {
                //Connect to DB to Login with existing Token
                $now = time();
                $_SESSION['token'] = $this->config->google_token;
                $gaToken= json_decode($_SESSION['token']);
                $expires = $gaToken->created + $gaToken->expires_in;
                if($now > $expires) {
                    $this->client->refreshToken($gaToken->refresh_token);
                    $this->model->update('config', array('value'=>$_SESSION['token']), 'name="google_token"');
                    if(!empty($this->cached)) $this->cached->clear_cached('cache_node', sprintf('cid LIKE "%s%%"', $this->model->clean('googleapi_')));
                }
                $this->client->setAccessToken($_SESSION['token']);
            } else {
                $authUrl = $this->client->createAuthUrl();
                return '<a id="google-login" href="'.$authUrl.'">Connect to Google!</a>'."\n";
            }
        } else {
            if($this->accessDB && empty($this->config->google_token)) {
                $this->model->update('config', array('value'=>$_SESSION['token']), 'name="google_token"');
            }
        }
        return null;
    }
    public function doCallBack(){
        if(!empty($this->referral))
            header('Location: ' . filter_var($this->referral, FILTER_SANITIZE_URL));
        return exit;
    }
    //Compose General Api
    public function composeApi($parameter = array(), $raw=false, $enableCache=true) {
        if(empty($parameter)) return null;
        $param = $this->buildParameters($parameter);
        if ($this->client->getAccessToken()) {
            try {
                //Check Cache
                if(!empty($this->cached) && $enableCache) {
                    $cached = $this->cached->is_cached('cache_node', 'googleapi_'.$param['name']);
                    if(!empty($cached)) {
                        $data = $cached;
                    } else {
                        $data = $this->googleServiceRequest($param);
                        $this->cached->add_cached('cache_node', 'googleapi_'.$param['name'], $data, 1440, 1);
                    }
                } else {
                    $data = $this->googleServiceRequest($param);
                }
                if(!empty($data)){
                    if($raw) return $data;
                    $header = $this->setHeaders($param['label']);
                    $ga_data="";
                    if(!empty($data['rows'])) {
                        foreach($data['rows'] as $rows) {
                            foreach($rows as $key => $column) {
                                if(empty($param['label']) || !empty($param['label'][$key])) {
                                    if(isset($param['format'][$key]) && $param['format'][$key]=='datetime')
                                        $rows[$key] =  "'".date('M j',strtotime($column))."'";
                                    else
                                        $rows[$key] = (!is_numeric($column)) ? "'".str_replace(array("'","\\")," ",strip_tags($column))."'" : $column;
                                } else unset($rows[$key]);
                            }
                            if($rows) $ga_data.="[".join(',', $rows)."],";
                        }
                    }
                    unset($data);
                    return $header . rtrim($ga_data,',');
                }
                unset($data);
            } catch (Google_ServiceException $e) {
                echo $e->getMessage();
            }
        }
    }
    //Build Params
    private function buildParameters($parameter){
        $param = array(
            'name'     => (!empty($parameter['name'])) ? $parameter['name'] : time(),
            'label'     => (!empty($parameter['label'])) ? $parameter['label'] : null,
            'from'      => (!empty($parameter['from'])) ? $parameter['from'] : date('Y-m-d', time()-30*24*60*60),
            'to'        => (!empty($parameter['to'])) ? $parameter['to'] : date('Y-m-d'),
            'format'     => (!empty($parameter['format'])) ? $parameter['format'] : null,
            'options'   => array()
        );
        if(!empty($parameter['metrics'])) {
            $metrics = $this->appendPrefix($parameter['metrics']);
            if(!empty($metrics)) $param['metrics'] = $metrics;
        }
        if(!empty($parameter['dimensions'])) {
            $dimensions = $this->appendPrefix($parameter['dimensions']);
            if(!empty($dimensions)) $param['options']['dimensions'] = $dimensions;
        }
        if(!empty($parameter['filters'])) {
            $filters = $this->appendPrefix($parameter['filters']);
            if(!empty($filters)) $param['options']['filters'] = $filters;
        }
        if(!empty($parameter['sort'])) $param['options']['sort'] = '-ga:'.$parameter['sort'];
        if(!empty($parameter['max-results'])) $param['options']['max'] = $parameter['max'];
        return $param;
    }
    private function googleServiceRequest($param){
        if(empty($param)) return null;
        return $this->service->data_ga->get('ga:'.@$this->config->google_project_id, $param['from'], $param['to'], $param['metrics'], $param['options']);
    }
    private function setHeaders($headers=null){
        if(empty($headers)) return null;
        foreach($headers as $hky=>$head) {
            $headers[$hky] = "'".str_replace(array("'","\\")," ",$head)."'";
            if(empty($head)) unset($headers[$hky]);
        }
        return '['.join(',', $headers).'],';
    }
    private function appendPrefix($entry){
        if(empty($entry)) return null;
        if(is_array($entry)) {
            $_string = '';
            foreach($entry as $part)
                $_string .= ',ga:' . $part;
            return trim($_string,',');
        } else {
            return 'ga:' . $entry;
        }
    }
}