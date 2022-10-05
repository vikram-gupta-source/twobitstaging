<?php
/**
 * WP Custom GeoIP Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'GeoIP' ) ) {

  class GeoIP {

    public $name,
           $prefix,
           $title,
           $slug;
    const FIELDS = '?fields=status,message,countryCode,regionName,city';
    const GEOIP_URL = 'http://pro.ip-api.com/json/';
    const GEOIP_STAGE_URL = 'http://ip-api.com/json/';

    public function __construct() {
      $this->name = 'geoip';
      $this->prefix = 'geo_';
      $this->title = 'Geo IP Settings';
      $this->slug = str_replace('_', '-', $this->name);
      if ( is_admin() ){ // admin actions
        add_action('admin_menu', [$this, $this->prefix . 'add_admin_page']);
        add_action('admin_init', [$this, $this->prefix . 'add_custom_settings']);
      }
    }

    public function geo_add_admin_page() {
      add_options_page(
        __( $this->title, 'textdomain' ),
        __( $this->title, 'textdomain' ),
        'manage_options',
        $this->slug,
        [$this, $this->prefix . 'render_settings_page']
      );
    }

    public function geo_add_custom_settings() {
      add_settings_section(
        $this->prefix . 'geoip_settings',
        'API Settings',
        [$this, $this->prefix . 'geoip_settings_callback'],
        $this->slug . '-api-settings'
      );
      register_setting(
        $this->prefix . 'geoip_settings',
        $this->prefix . 'api_keys'
      );
    }

    private function build_api_url($ip) {
      $api_options = get_option($this->prefix . 'api_keys');
      $apikey = (!empty($api_options['api'])) ? $api_options['api'] : '';
      return (($apikey) ? self::GEOIP_URL : self::GEOIP_STAGE_URL ) . $ip . self::FIELDS .  (($apikey) ? '&key=' . $api_options['api'] : '');
    }
    private function get_location($ip) {
      $url = $this->build_api_url($ip);
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_TIMEOUT => 5
        ));
      $result = curl_exec($curl);
      curl_close($curl);
      return json_decode($result);
    }

    public function geo_geoip_settings_callback() {
      settings_fields($this->prefix . 'geoip_settings');
      $this->geo_api_settings_callback();
    }

    public function geo_api_settings_callback() {
      $api_options = get_option($this->prefix . 'api_keys');
      ?>
      <p>GEO IP is from IP-API <a href="http://ip-api.com/">http://ip-api.com/</a></p>
      <label for="<?php echo $this->prefix; ?>api_keys[api]">API Key</label>
      <input name="<?php echo $this->prefix; ?>api_keys[api]" type="text" value="<?php echo $api_options['api']; ?>" />
      <br>
      <?php
    }

    public function geo_render_settings_page() {
      ?>

      <div class="wrap">

        <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
        <form method="post" action="options.php">

          <?php
          do_settings_sections($this->slug . '-api-settings');
          submit_button('Save Geo Settings', 'primary', 'submit');
          ?>

        </form>
      </div>

      <?php
    }

    public function get_location_by_ip( $ip = "" ) {
      $ip = '174.246.199.122';//$this->get_ip_address();
      try {
        $location = $this->get_location($ip);
				if(!empty($location->status) && $location->status == 'success' && $location->countryCode == 'US') {
					if($location->regionName != 'California' && $location->regionName != 'Texas') {
						$location->regionName = 'California';
						$location->city = 'Los Angeles';
					}
				} else {
					$location = new stdClass();
					$location->status = 'success';
					$location->countryCode = 'US';
					$location->regionName = 'California';
					$location->city = 'Los Angeles';
				}
        setcookie('geo_location', json_encode($location), time()+60*60*24, '/');
        return $location;
      } catch ( Exception $e ) {
				$location = new stdClass();
				$location->status = 'success';
				$location->countryCode = 'US';
				$location->regionName = 'California';
				$location->city = 'Los Angeles';
				setcookie('geo_location', json_encode($location), time()+60*60*24, '/');
      }
    }

    /**
  	 * We get user IP but check with different services to see if they provided real user ip
  	 * @return mixed|void
  	 */
  	public function get_ip_address() {
  		$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '1.1.1.1';
  		// cloudflare
  		$ip = isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $ip;
  		// reblaze
  		$ip = isset( $_SERVER['X-Real-IP'] ) ? $_SERVER['X-Real-IP'] : $ip;
  		// Sucuri
  		$ip = isset( $_SERVER['HTTP_X_SUCURI_CLIENTIP'] ) ? $_SERVER['HTTP_X_SUCURI_CLIENTIP'] : $ip;
  		// Ezoic
  		$ip = isset( $_SERVER['X-FORWARDED-FOR'] ) ? $_SERVER['X-FORWARDED-FOR'] : $ip;
  		// akamai
  		$ip = isset( $_SERVER['True-Client-IP'] ) ? $_SERVER['True-Client-IP'] : $ip;
  		// Clouways
  		$ip = isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $ip;
  		// varnish trash ?
  		$ip = str_replace( array( '::ffff:', ', 127.0.0.1'), '', $ip );
			if(preg_match('/,/', $ip)) {
				$ips = explode(',', $ip);
				$ip = trim($ips[0]);
			}
      if($ip == '127.0.0.1' || $ip == '::1') $ip = '24.176.217.66';
  		return $ip;
  	}
  }
}
