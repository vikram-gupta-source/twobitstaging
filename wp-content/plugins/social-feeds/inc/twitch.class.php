<?php
namespace Petrol;
if(!defined('IN_PROJECT')) exit('No direct script access allowed');

class Twitch extends Feed {

    public $isfile = true;
    public $sid = '';
    public $limit = 25;
    public $ins = '';
    public $file_path = '/cache/twitch_feed.json';
	  private $model;
    private $apiUrl = 'https://api.twitch.tv/kraken';
    private $table = 'feeds';

	public function __construct(Controller &$ctrl) {
        $this->model = &$ctrl->model;
    }
    public function load_twitch_feed() {
        if(empty($this->ins)) return null;
        $data = $this->getChannel($this->ins);
        if(!empty($data)) {
            return $this->twitch_write($data);
        } else return null;
    }
    public function getApiUri($type) {
		$apiCalls = array(
			"streams" => $this->apiUrl."/streams/",
			"search" => $this->apiUrl."/search/",
			"channel" => $this->apiUrl."/channels/",
			"user" => $this->apiUrl."/user/",
			"teams" => $this->apiUrl."/teams/",
		);
		return $apiCalls[$type];
	}
    public function apiConnect($url) {
        if(empty($url)) return null;
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
        $header = @get_headers($url);
        if(preg_match('/^HTTP(.*)(200|301|302)(.*)$/i', $header[0])) {
            $feed = @file_get_contents($url);
        }
        return (!empty($feed)) ? $feed : null;
    }
  public function getFeatured($game) {
		$s = $this->apiConnect($this->getApiUri("streams")."?game=".urlencode($game)."&limit=1&offset=0");
        if(empty($s)) return null;
		$activeStreams = json_decode($s);
		$streams = $activeStreams["streams"];
		foreach($streams as $stream) {
			return $stream["channel"]["name"];
		}
	}
	public function getStreams($game, $page) {
		$offset = ($page-1)*$this->limit;
		$s = $this->apiConnect($this->getApiUri("streams")."?game=".urlencode($game)."&limit=$this->limit&offset=$offset");
    if(empty($s)) return null;
		$activeStreams = json_decode($s);
		$streams = $activeStreams["streams"];
		$final = "";
		foreach($streams as $stream) {
			$imgsm = $stream["preview"]["small"];
			$imgmed = $stream["preview"]["medium"];
			$viewers = $stream["viewers"];
			$channel = $stream["channel"];
			$status = $channel["status"];
			$twitchName = $channel["name"];
			$twitchDisplay = $channel["display_name"];
			$twitchLink = $channel["url"];
			$final .= "<a class=\"stream-item\" href=\"/users/$twitchName\"><img src=\"$imgmed\"><span class=\"name\">$status</span><span class=\"viewers\">$viewers viewers</span></a>";
		}
		echo $final;
	}
	public function getChannel($channel) {
		$c = $this->apiConnect($this->getApiUri("channel").$channel);
        if(empty($c)) return null;
		$channelData = json_decode($c);
		return $channelData;
	}
	public function getFollowers($channel) {
		$f = $this->apiConnect($this->getApiUri("channel").$channel."/follows");
        if(empty($f)) return null;
		$followData = json_decode($f);
		return $followData["_total"];
	}
	public function getChannelStream($channel) {
		$s = $this->apiConnect($this->getApiUri("streams").$channel);
        if(empty($s)) return null;
		$streamData = json_decode($s);
		return $streamData;
	}
    private function twitch_write($entry=null) {
        if(empty($entry)) return null;
        if($this->isfile===false) {
            //Wipe Data from DB
            $this->model->delete($this->table, 'type="twitch"');
            //pr($data);
            //foreach($data as $entry) {
                if(!empty($entry->status)) {
                    $this->model->insert($this->table, array(
                        'sid' => $this->sid,
                        'type' => 'twitch',
                        'pubdate' =>  strtotime($entry->updated_at),
                        'user' => $entry->name,
                        'icon' => (isset($entry->logo)) ? $entry->logo : '',
                        'image' => (isset($entry->video_banner)) ? $entry->video_banner : '',
                        'link' => $entry->url,
                        'title' => $entry->status,
                        'text' => '',
                        'count' => $entry->views,
                        'count2' => $entry->followers,
                    ));
                }
            //}
            return 'passed';
        } else {
            //Save to File
            $feedEncode = json_encode($data);
            @file_put_contents($this->file_path, $feedEncode);
            return json_decode($feedEncode);
        }
    }
}
?>
