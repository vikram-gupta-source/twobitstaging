<?php
/**
 * Main setup scripts
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'twobitcircus_admin_menu_logo' ) ) {
  add_action('admin_menu', 'twobitcircus_admin_menu_logo');

  function twobitcircus_admin_menu_logo() {
      global $menu;
      $url = '/';
      $menu[0] = array( '<img class="brand-logo" src="/wp-content/uploads/2019/05/animated-logo.gif" />', 'read', $url, 'twobitcircus-logo', 'twobitcircus-logo');
  }
}
// ALow Featured Images
add_theme_support( 'post-thumbnails' );
// Hide Bottom Left Wordpress Copy
add_action('admin_footer_text','__return_false');

// Remove elements from menu
function remove_menus() {
	remove_menu_page( 'edit-comments.php' );
  remove_menu_page( 'edit.php' );
}
//add_action( 'admin_menu', 'remove_menus' );

// Disable all user admin top bar
add_filter('show_admin_bar', '__return_false');

// Enable Option Seetting ACF
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
    'menu_title'	=>  __('Two Bit Settings'),
    'menu_slug' 	=> 'acf-options',
    'position'    => 51
  ));
}
// Enable Option Calender ACF
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Calendar',
		'menu_title'	=> 'Calendar',
		'menu_slug' 	=> 'calendar',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
    'icon_url'    => 'dashicons-calendar-alt',
    'position'    => 49
	));
}

function custom_acf_flexible_content_layout_title( $title, $field, $layout, $i ) {
	// load text sub field
	if( !empty(get_sub_field('region')) && !empty(get_sub_field('city'))) {
		return get_sub_field('city')  . ', ' . get_sub_field('region');
	}
  if( !empty(get_sub_field('locations'))) {
    $filter = (preg_match('/all|all/', get_sub_field('locations'))) ? 'All Locations' : str_replace('|', ', ', get_sub_field('locations'));
    if(!empty(get_sub_field('title'))) {
      return $filter . ' - ' . get_sub_field('title');
    }
    if(!empty(get_sub_field('show_title'))) {
      return $filter . ' - ' . get_sub_field('show_title') . ' - ' . get_sub_field('show_date');
    }
    return $filter;
  }
  if( !empty(get_sub_field('title'))) {
    return get_sub_field('title');
  }
	// return
	return $title;
}
// name
add_filter('acf/fields/flexible_content/layout_title', 'custom_acf_flexible_content_layout_title', 10, 4);

// Collapse All Default
function twobit_acf_admin_head() {
    ?>
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                $('.layout').addClass('-collapsed');
                $('.acf-postbox').addClass('closed');
                $('#wpseo_meta.postbox').addClass('closed');
            });
        })(jQuery);
    </script>
    <?php
}
add_action('acf/input/admin_head', 'twobit_acf_admin_head');

add_filter('manage_edit-category_columns', 'twobit_cat_order', 10, 2);
add_action( "manage_category_custom_column", 'twobit_cat_order_column_content', 10, 3);
function twobit_cat_order($cat_columns) {
    $cat_columns['category_order'] = 'Order';
    return $cat_columns;
}
function twobit_cat_order_column_content( $value, $column_name, $tax_id ){
   $cat_meta = get_term_meta($tax_id, 'category_order', true);
   return (!empty($cat_meta)) ? $cat_meta : 0;
}

//add extra fields to category edit form hook
add_action( 'created_category', 'twobit_taxonomy_save_taxonomy_meta', 10, 2 );
add_action( 'edited_category', 'twobit_taxonomy_save_taxonomy_meta', 10, 2 );
add_action ( 'edit_category_form_fields', 'twobit_taxonomy_edit_category_fields');
add_action ( 'category_add_form_fields', 'twobit_taxonomy_add_category_fields');

//add extra fields to category edit form callback function
function twobit_taxonomy_add_category_fields() {
?>
<div class="form-field form-required term-name-wrap">
	<label for="category_order">Order</label>
	<input name="category_order" id="category_order" type="text" value="0" size="10">
</div>
<?php
}
//add extra fields to category edit form callback function
function twobit_taxonomy_edit_category_fields( $tag ) {
    $t_id = $tag->term_id;
    $cat_meta = get_term_meta($t_id, 'category_order', true);
?>
<tr class="form-field form-required term-name-wrap">
  <th scope="row"><label for="name">Order</label></th>
  <td><input name="category_order" id="category_order" type="text" value="<?php echo (!empty($cat_meta)) ? $cat_meta : 0; ?>" size="40" aria-required="true"></td>
</tr>
<?php
}
// Save custom meta
function twobit_taxonomy_save_taxonomy_meta( $term_id, $tag_id ) {
    if ( isset( $_POST[ 'category_order' ] ) ) {
        update_term_meta( $term_id, 'category_order', $_POST[ 'category_order' ] );
    } else {
        update_term_meta( $term_id, 'category_order', '' );
    }
}
function custom_term_sort($terms) {
	$ordered_terms = array();
	foreach($terms as $term) {
		if(is_object($term)) {
			$taxonomy_sort = get_term_meta($term->term_id, 'category_order', true);
			$term->category_order = (!empty($taxonomy_sort)) ? (int) $taxonomy_sort : 0;
			$ordered_terms[] = $term;
		}
  }
  if(empty($ordered_terms)) return $terms;
  $ordered_terms = custom_term_sort_format($ordered_terms);
  //print_r($ordered_terms);
	return $ordered_terms;
}
function custom_term_sort_format($ordered_terms) {
  $sorted = array();
  if(empty($ordered_terms)) return $ordered_terms;
  foreach($ordered_terms as $key => $item) {
    if(!array_key_exists($item->category_order, $sorted)) {
      $sorted[$item->category_order] = $item;
    } else {
      $sorted[$key] = $item;
    }
  }
  krsort($sorted);
  return $sorted;
}
