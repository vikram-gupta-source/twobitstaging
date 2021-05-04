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
      $this->title = 'Instagram Feed';
      $this->slug = str_replace('_', '-', $this->name);
      if ( is_admin() ){ // admin actions
        add_action('admin_menu', [$this, $this->prefix . 'add_admin_page']);
        add_action('admin_init', [$this, $this->prefix . 'add_custom_settings']);
        // Create a handler for the AJAX toolbar requests.
        add_action( 'wp_ajax_feed_delete_cache', array('InstagramAdmin', 'delete_cache' ) );
      }
    }

    public function instagram_add_admin_page() {
      add_menu_page(
        __( $this->title, 'textdomain' ),
        __( $this->title, 'textdomain' ),
        'manage_options',
        $this->slug,
        [$this, $this->prefix . 'render_settings_page'],
        'dashicons-instagram',
        50
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
      <p><input type="button" name="wipe-feed-cache" id="wipe-feed-cache" class="button button-primary" value="Clear Instagram Cache">
      <a href="/wp-admin/admin.php?page=instagram&action=populate"><input type="button" name="get-instagram" id="get-instagram" class="button button-primary" value="Get Latest Instagram"></a></p>
      <div id="wipe-message"></div>
      <hr>
      <h2>Instagram API Settings</h2>
      <div class="form-wrap" style="max-width: 500px;">
        <div class="form-field">
          <label style="display:inline" for="<?php echo $this->prefix; ?>insta_api_keys[enable]">Enable Instagram </label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[enable]" type="checkbox" <?php echo (isset($insta_api_options['enable']) && $insta_api_options['enable']) ? 'checked' : ''; ?> />
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
          <label for="<?php echo $this->prefix; ?>insta_api_keys[likes]">Instagram Likes Required</label>
          <input name="<?php echo $this->prefix; ?>insta_api_keys[likes]" type="text" value="<?php echo $insta_api_options['likes']; ?>" />
        </div>
        <input id="action-instagram" name="action_instagram" type="hidden" value="" />
      </div>
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
        <hr>
      </div>

      <hr>
      <?php
      $listTable = new Instagram_List_Table();
      $_count = $listTable->prepare_items();
      ?>
     <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <div class="wrap">
        <form id="page-filter" method="post">
          <?php $listTable->display(); ?>
        </form>
      </div>
      <?php
    }
    // Hadnel Delete Table
    public function delete_cache() {
      global $wpdb;
      if ( current_user_can( 'manage_options' ) ) {
        $table_name = $wpdb->prefix . 'instagram_feeds';
        $querystr = 'TRUNCATE TABLE ' . $table_name;
        $wpdb->query($querystr);
        self::wipe_directory();
      }
      die();
    }
    // Hadnel Delete Directoy
    private function wipe_directory() {
      $filepath = ABSPATH . '/wp-content/uploads/instagram/*';
      $files = glob($filepath);
      foreach($files as $file) {
        if(is_file($file)) {
          unlink($file);
        }
      }
    }
  }

  if(!class_exists('WP_List_Table')){
      require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }

  class Instagram_List_Table extends WP_List_Table {

    public $prefix;
    public $table;

    public function __construct(){
        global $wpdb, $status, $page;
        $this->table = $wpdb->prefix . 'instagram_feeds';
  			//Set parent defaults
  			parent::__construct( array(
  					'singular'  => 'instagram',     //singular name of the listed records
  					'plural'    => 'instagrams',    //plural name of the listed records
  					'ajax'      => false        //does this table support ajax?
  			) );
  	}
    function process_bulk_action() {
      global $wpdb;
      $action = $this->current_action();
      if( 'disable' == $action && !empty($_REQUEST['cb_action'])) {
        foreach ( $_REQUEST['cb_action'] as $post_id ) {
          $result = $wpdb->query('UPDATE '.$this->table.' SET `status` = 1 WHERE `id`='.$post_id);
        }
      }
      elseif( 'enable' == $action && !empty($_REQUEST['cb_action'])) {
        foreach ( $_REQUEST['cb_action'] as $post_id ) {
          $result = $wpdb->query('UPDATE '.$this->table.' SET `status` = 0 WHERE `id`='.$post_id);
        }
      }
      elseif( 'delete' == $action && !empty($_REQUEST['cb_action'])) {
        foreach ( $_REQUEST['cb_action'] as $post_id ) {
          $result = $wpdb->query('DELETE FROM '.$this->table.' WHERE `id`='.$post_id);
        }
      }
      return false;
    }
  	public function column_default($item, $column_name){
  			switch($column_name) {
  				case 'pubdate':
  				 	return date_i18n( get_option( 'date_format' ), strtotime($item->{$column_name}));
          case 'caption':
    				return wp_trim_words($item->{$column_name}, 25);
          case 'image':
            return '<img style="width: 150px; height: auto;" src="'.$item->{$column_name}.'"/>';
          case 'link':
            return '<a href="'.$item->{$column_name}.'" target="_blank">'.$item->{$column_name}.'</a>';
          case 'status':
            return ($item->{$column_name} == 1) ? '<span style="color: red;">Disabled</span>'  : '<span style="color: green;">Enabled</span>';
  				default:
  				 	return $item->{$column_name};
  			}
  	}
    function get_bulk_actions() {
      $actions = array(
        'disable'  => __('Disable'),
        'enable'    => __('Enable'),
        'delete'    => __('Delete')
      );
      return $actions;
    }
    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="cb_action[]" value="%s" />', $item->id
        );
    }
  	public function get_columns(){
			$columns = array(
        'cb' => '<input type="checkbox" />',
        'image' => 'Image',
				'pubdate'     => 'Date',
				'instagram_id'    => 'Instagram ID',
				'link'  => 'link',
				'count' => 'Comments',
				'count2' => 'Likes',
        'caption'  => 'Caption',
				'status'  => 'Status'
			);
  		return $columns;
  	}
  	public function get_sortable_columns() {
  			$sortable_columns = array(
  				  'pubdate'      => array('pubdate',false), 
  					'status'  => array('status',false)
  			);
  			return $sortable_columns;
  	}
  	public function prepare_items() {
  			global $wpdb;
  			$per_page = 30;
  			$columns = $this->get_columns();
  			$hidden = $dataQry = array();
  			$query = '';
        $this->process_bulk_action();
  			$sortable = $this->get_sortable_columns();
  			$this->_column_headers = array($columns, $hidden, $sortable);
  			$searchcol= array(
  		    'instagram_id'
  		    );
  			if(!empty($_POST["s"])) {
  				foreach( $searchcol as $col) {
  					$dataQry[] = $col.' LIKE "%'.trim($_POST["s"]).'%"';
  				}
  				$query = ' WHERE (' . implode(' OR ', $dataQry) . ')';
  			}
  			$request = "SELECT * FROM " . $this->table . $query;
  			$data = $wpdb->get_results($request);
        usort($data, 'insta_usort_reorder');
        if(!empty($data)) {
    			$current_page = $this->get_pagenum();
    			$total_items = count($data);
    			$data = array_slice($data,(($current_page-1)*$per_page),$per_page);
    			$this->items = $data;
    			$this->set_pagination_args( array(
    					'total_items' => $total_items,                  //WE have to calculate the total number of items
    					'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
    					'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
    			) );
          return $total_items;
        }
  			return null;
  	}
  }

}

function insta_usort_reorder($a,$b){
		$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'pubdate'; //If no sort, default to title
		$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
		$result = strcmp($a->{$orderby}, $b->{$orderby}); //Determine sort order
		return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
}
