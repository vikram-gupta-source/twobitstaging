<?php
/**
 * WP Custom SocialAdmin Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'SocialAdmin' ) ) {

  class SocialAdmin {
    public $name,
           $prefix,
           $title,
           $slug;

    public function __construct() {
      $this->name = 'feeds';
      $this->prefix = 'social_';
      $this->title = 'Social Feed API';
      $this->slug = str_replace('_', '-', $this->name);
      if ( is_admin() ){ // admin actions
        add_action('admin_menu', [$this, $this->prefix . 'add_admin_page']);
        add_action('admin_init', [$this, $this->prefix . 'add_custom_settings']);
      }
    }

    public function social_add_admin_page() {
      add_options_page(
        __( $this->title, 'textdomain' ),
        __( $this->title, 'textdomain' ),
        'manage_options',
        $this->slug,
        [$this, $this->prefix . 'render_settings_page']
      );
    }

    public function social_add_custom_settings() {
      add_settings_section(
        $this->prefix . 'feeds_settings',
        'Facebook API Settings',
        [$this, $this->prefix . 'feeds_settings_callback'],
        $this->slug . '-api-settings'
      );
      register_setting(
        $this->prefix . 'feeds_settings',
        $this->prefix . 'fb_api_keys'
      );

      register_setting(
        $this->prefix . 'feeds_settings',
        $this->prefix . 'tw_api_keys'
      );

      register_setting(
        $this->prefix . 'feeds_settings',
        $this->prefix . 'insta_api_keys'
      );

      register_setting(
        $this->prefix . 'feeds_settings',
        $this->prefix . 'yt_api_keys'
      );
    }

    public function social_feeds_settings_callback() {
      settings_fields($this->prefix . 'feeds_settings');
      $this->social_api_settings_callback();
    }

    public function social_api_settings_callback() {
      $fb_api_options = get_option($this->prefix . 'fb_api_keys');
      $tw_api_options = get_option($this->prefix . 'tw_api_keys');
      $insta_api_options = get_option($this->prefix . 'insta_api_keys');
      $yt_api_options = get_option($this->prefix . 'yt_api_keys');
      ?>
      <div class="form-wrap" style="max-width: 500px;">
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>fb_api_keys[appid]">Facebook APP ID</label>
          <input name="<?php echo $this->prefix; ?>fb_api_keys[appid]" type="text" value="<?php echo $fb_api_options['appid']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>fb_api_keys[secret]">Facebook APP Secret</label>
          <input name="<?php echo $this->prefix; ?>fb_api_keys[secret]" type="text" value="<?php echo $fb_api_options['secret']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>fb_api_keys[sid]">Facebook Client ID</label>
          <input name="<?php echo $this->prefix; ?>fb_api_keys[sid]" type="text" value="<?php echo $fb_api_options['sid']; ?>" />
          <p>Facebook ID is required.  <a href="https://findmyfbid.com/" target="_blank">Get Facebook ID</a></p>
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>fb_api_keys[name]">Facebook Client Name</label>
          <input name="<?php echo $this->prefix; ?>fb_api_keys[name]" type="text" value="<?php echo $fb_api_options['name']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>fb_api_keys[token]">Facebook Token</label>
          <input name="<?php echo $this->prefix; ?>fb_api_keys[token]" type="text" value="<?php echo $fb_api_options['token']; ?>" />
          <p>Token is required to pull data.  You can generate this token <a href="/wp-content/plugins/social-feeds/inc/vendors/Facebook/callback.php" target="_blank">Get Token</a>.  Token will expire in 60 days.</p>
        </div>
      </div>
      <br><hr>
      <h2>Twitter API Settings</h2>
      <div class="form-wrap" style="max-width: 500px;">
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>tw_api_keys[appid]">Twitter APP ID</label>
          <input name="<?php echo $this->prefix; ?>tw_api_keys[appid]" type="text" value="<?php echo $tw_api_options['appid']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>tw_api_keys[secret]">Twitter APP Secret</label>
          <input name="<?php echo $this->prefix; ?>tw_api_keys[secret]" type="text" value="<?php echo $tw_api_options['secret']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>tw_api_keys[token_access]">Twitter Access Token</label>
          <input name="<?php echo $this->prefix; ?>tw_api_keys[token_access]" type="text" value="<?php echo $tw_api_options['token_access']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>tw_api_keys[token_secret]">Twitter Token Secret</label>
          <input name="<?php echo $this->prefix; ?>tw_api_keys[token_secret]" type="text" value="<?php echo $tw_api_options['token_secret']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>tw_api_keys[name]">Twitter Client Name</label>
          <input name="<?php echo $this->prefix; ?>tw_api_keys[name]" type="text" value="<?php echo $tw_api_options['name']; ?>" />
        </div>
      </div>
      <br><hr>
      <h2>Instagram API Settings</h2>
      <div class="form-wrap" style="max-width: 500px;">
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>insta_api_keys[appid]">Instagram APP ID</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[appid]" type="text" value="<?php echo $insta_api_options['appid']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>insta_api_keys[secret]">Instagram APP Secret</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[secret]" type="text" value="<?php echo $insta_api_options['secret']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>insta_api_keys[token]">Instagram Token</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[token]" type="text" value="<?php echo $insta_api_options['token']; ?>" />
          <p>Token is required to pull data.  You can generate this token <a href="/wp-content/plugins/social-feeds/inc/vendors/instagram/callback.php" target="_blank">Get Token</a>.</p>
        </div>
      </div>
      <br><hr>
      <h2>Youtube API Settings</h2>
      <div class="form-wrap" style="max-width: 500px;">
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>yt_api_keys[appid]">Youtube APP ID</label>
          <input name="<?php echo $this->prefix; ?>yt_api_keys[appid]" type="text" value="<?php echo $yt_api_options['appid']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>yt_api_keys[name]">Twitter Client Name</label>
          <input name="<?php echo $this->prefix; ?>yt_api_keys[name]" type="text" value="<?php echo @$yt_api_options['name']; ?>" />
        </div>
        <div class="form-field">
          <label for="<?php echo $this->prefix; ?>yt_api_keys[sid]">Twitter Client Code</label>
          <input name="<?php echo $this->prefix; ?>yt_api_keys[sid]" type="text" value="<?php echo @$yt_api_options['sid']; ?>" />
        </div>
      </div>
      <br><hr>
      <?php
    }

    public function social_render_settings_page() {
      ?>
      <div class="wrap">
        <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
        <form method="post" action="options.php">
          <?php
          do_settings_sections($this->slug . '-api-settings');
          submit_button('Save Social Settings', 'primary', 'submit');
          ?>
        </form>
      </div>
      <?php
    }

  }

}
