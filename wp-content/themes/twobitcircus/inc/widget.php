<?php
/**
 * Main widget
 *
 * @package probablymonsters
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Register and load the widget
class Social_Icons extends WP_Widget {
	public function __construct() {
    $widget_ops = array(
  		'classname' => 'social_icons',
  		'description' => 'Dispaly Social Icons',
  	);
	  parent::__construct( 'social_icons', 'Social Icons', $widget_ops );
  }
	// output the widget content on the front-end
  public function widget( $args, $instance ) {
  	echo $args['before_widget'];
  	if ( ! empty( $instance['title'] ) ) {
  		echo '<a href="'.$instance['link'].'" target="_blank" rel="noopener noreferrer" alt="'.apply_filters( 'widget_title', $instance['title'] ).'"><i class="'.$instance['class'].'"></i></a>';
  	}
	  echo $args['after_widget'];
  }
	// output the option form field in admin Widgets screen
  public function form( $instance ) {
  	$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Title', 'twobitcircus' );
    $class = ! empty( $instance['class'] ) ? $instance['class'] : esc_html__( 'Icon Class', 'twobitcircus' );
    $link = ! empty( $instance['link'] ) ? $instance['link'] : esc_html__( 'Link', 'twobitcircus' );
  	?>
  	<p>
  	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
  	<?php esc_attr_e( 'Title:', 'twobitcircus' ); ?>
  	</label>
  	<input
  		class="widefat"
  		id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
  		name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
  		type="text"
  		value="<?php echo esc_attr( $title ); ?>">
  	</p>

    <p>
  	<label for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>">
  	<?php esc_attr_e( 'Icon Class:', 'twobitcircus' ); ?>
  	</label>
  	<input
  		class="widefat"
  		id="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"
  		name="<?php echo esc_attr( $this->get_field_name( 'class' ) ); ?>"
  		type="text"
  		value="<?php echo esc_attr( $class ); ?>">
  	</p>

    <p>
  	<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>">
  	<?php esc_attr_e( 'Link:', 'twobitcircus' ); ?>
  	</label>
  	<input
  		class="widefat"
  		id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"
  		name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>"
  		type="text"
  		value="<?php echo esc_attr( $link ); ?>">
  	</p>
  	<?php
  }
	// save options
	public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['class'] = ( ! empty( $new_instance['class'] ) ) ? strip_tags( $new_instance['class'] ) : '';
    $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
    return $instance;
  }
}
// register Social
add_action( 'widgets_init', function(){
	register_widget( 'Social_Icons' );
});

/**
 * Register our sidebars and widgetized areas.
 *
 */
function twobit_widgets_init() {
  if(function_exists('register_sidebar')) {
    register_sidebar( array(
      'name' => 'Footer Column 1',
      'id' => 'footer-bar-1',
      'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
      'after_widget' => '</div>',
    ) );
    register_sidebar( array(
      'name' => 'Footer Column 2',
      'id' => 'footer-bar-2',
      'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
      'after_widget' => '</div>',
    ) );
    register_sidebar( array(
      'name' => 'Footer Column 3',
      'id' => 'footer-bar-3',
      'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
      'after_widget' => '</div>',
    ) );
  }
}
add_action( 'widgets_init', 'twobit_widgets_init' );
