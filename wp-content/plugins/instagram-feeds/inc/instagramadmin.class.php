<?php
/**
 * WP Custom Instagram Admin Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'InstagramAdmin' ) ) {

  class InstagramAdmin {
    public $name,
           $prefix,
           $title,
           $slug;

    public function __construct() {
      $this->name = 'instagram';
      $this->prefix = 'instagram_';
      $this->title = 'Instagram Feed API';
      $this->slug = str_replace('_', '-', $this->name);
      if ( is_admin() ){ // admin actions
        add_action('admin_menu', [$this, $this->prefix . 'add_admin_page']);
        add_action('admin_init', [$this, $this->prefix . 'add_custom_settings']);
        // Create a handler for the AJAX toolbar requests.
        add_action( 'wp_ajax_feed_delete_cache', array('InstagramAdmin', 'delete_cache' ) );
      }
    }

    public function instagram_add_admin_page() {
      add_options_page(
        __( $this->title, 'textdomain' ),
        __( $this->title, 'textdomain' ),
        'manage_options',
        $this->slug,
        [$this, $this->prefix . 'render_settings_page']
      );
    }

    public function instagram_add_custom_settings() {
      add_settings_section(
        $this->prefix . 'settings', '',
        [$this, $this->prefix . 'settings_callback'],
        $this->slug . '-api-settings'
      );
      register_setting(
        $this->prefix . 'instagram_settings',
        $this->prefix . 'insta_api_keys'
      );
    }

    public function instagram_settings_callback() {
      settings_fields($this->prefix . 'instagram_settings');
      $this->instagram_api_settings_callback();
    }

    public function instagram_api_settings_callback() {
      $insta_api_options = get_option($this->prefix . 'insta_api_keys');
      ?>
      <p><b>Wipe All Instagram Feeds <a id="wipe-feed-cache" href="/wp-admin/options-general.php?page=instagram">Clear Feed</a></b></p>
      <div id="wipe-message"></div>
      <p><input type="button" name="get-instagram" id="get-instagram" class="button button-primary" value="Get Latest Instagram Posts"></p>
      <div id="get-instagram-message"></div> 
      <hr>
      <h2>Instagram API Settings</h2>
      <div class="form-wrap" style="max-width: 500px;">
        <div class="form-field">
          <label style="display:inline" for="<?php echo $this->prefix; ?>insta_api_keys[enable]">Enable Instagram </label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[enable]" type="checkbox" <?php echo (isset($insta_api_options['enable']) && $insta_api_options['enable']) ? 'checked' : ''; ?> />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>insta_api_keys[appid]">Instagram APP ID</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[appid]" type="text" value="<?php echo $insta_api_options['appid']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>insta_api_keys[secret]">Instagram APP Secret</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[secret]" type="text" value="<?php echo $insta_api_options['secret']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>insta_api_keys[hash]">Instagram Hash Tag</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[hash]" type="text" value="<?php echo $insta_api_options['hash']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>insta_api_keys[limit]">Instagram Limit</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[limit]" type="text" value="<?php echo $insta_api_options['limit']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>insta_api_keys[token]">Instagram Token</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[token]" type="text" value="<?php echo $insta_api_options['token']; ?>" />
          <p>Token is required to pull data.  You can generate this token <a href="/wp-content/plugins/instagram-feeds/inc/vendors/instagram/callback.php" target="_blank">Get Token</a>.</p>
        </div>
      </div>
      <br><hr>
      <?php
    }

    public function instagram_render_settings_page() {
      ?>
      <div class="wrap">
        <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
        <form method="post" action="options.php">
          <?php
          do_settings_sections($this->slug . '-api-settings');
          submit_button('Save Instagram Settings', 'primary', 'submit');
          ?>
        </form>
      </div>
      <?php
    }
    public function delete_cache(){
      global $wpdb;
      if ( current_user_can( 'manage_options' ) ) {
        $table_name = $wpdb->prefix . 'instagram_feeds';
        $querystr = 'TRUNCATE TABLE ' . $table_name;
        $wpdb->query($querystr);
      }
      die();
    }

  }

}
