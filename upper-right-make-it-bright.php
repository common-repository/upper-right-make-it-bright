<?php
	/**
	 * Genesis - Upper Right Make It Bright
	 *
	 * @package		Genesis - Upper Right Make It Bright
	 * @author		RedbrickDigital.net
	 * @copyright	2016 RedbrickDigital.net
	 * @license		GPL-2.0+
	 * @link		https://plugins.svn.wordpress.org/genesis
	 *
	 * @wordpress-plugin
	 * Plugin Name: Genesis - Upper Right Make It Bright
	 * Description: This plugin enables a widget area above the header on most Genesis Themes. Note: This requires a Genesis Child Theme to work.
	 * Version:     1.1.3.2
	 * Author:      RedbrickDigital.net
	 * Text Domain: genesis-upper-right
	 * License:     GPL-2.0+
	 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
	*/

	##        (\ /)
	##       ( . .) ♥ ~< Code Block - A: Standard Functions >
	##       c(”)(”)

	/**
	 * Enqueue Stylesheets and Scripts
	 *
	 * @since 0.1
	*/
	add_action( 'wp_enqueue_scripts', 'upper_right_make_it_bright_front_css' );
	function upper_right_make_it_bright_front_css(){
		# Scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'upper-right-make-it-bright', plugins_url( '/assets/js/upper-right-make-it-bright.js', __FILE__ ), array('jquery'), '', true );

		# CSS
		wp_enqueue_style( 'upper-right-make-it-bright', plugins_url( '/assets/css/upper-right-make-it-bright.css', __FILE__ ), [], '1.1' );
	}

	/**
	 * Register Sidebar through Genesis
	 *
	 * @since 0.1
	*/
	add_action( 'genesis_setup', 'upper_right_make_it_bright_genesis_sidebar' );
	function upper_right_make_it_bright_genesis_sidebar(){
		if( function_exists( 'genesis_register_sidebar' ) ){
			genesis_register_sidebar( array(
				'id'          => 'upper-right-make-it-bright',
				'name'        => __( 'Upper Right, Make It Bright', 'genesis-upper-right' ),
				'description' => __( 'This section allows you to add items to the upper right, and make them bright.', 'genesis-upper-right' ),
			) );
		}
	}

	/**
	 * Widget Area Modification through Genesis
	 *
	 * @since 0.1
	*/
	function upper_right_make_it_bright_widgets() {
		if( function_exists( 'genesis_widget_area' ) ){
			$columns = count_sidebar_widgets( 'upper-right-make-it-bright' );
			genesis_widget_area( 'upper-right-make-it-bright', array(
				'before' => '<div class="site-header"><div id="brightness-over-9000" class="brightness-over-9000"><div class="grid" columns="'. $columns .'">',
				'after'  => '</div><div class="clear-both"></div></div>',
			) );
		}
	}

	function count_sidebar_widgets( $sidebar_id, $echo = true ) {
	    $the_sidebars = wp_get_sidebars_widgets();
	    if( !isset( $the_sidebars[$sidebar_id] ) )
	        return __( 'Invalid sidebar ID' );

	    return count( $the_sidebars[$sidebar_id] );
	}

	/**
	 * Hacky Closing Tag
	 *
	 * @since 0.4
	 * @internal { Some themes were breaking when being wrapped in the
 	 *	`genesis_widget_area` function. So we open some divs in there and close
 	 *	all but one of those divs, and then close that one here. }
	*/
	add_action( 'genesis_after_header', 'upper_right_make_it_bright_stupid_header' );
	function upper_right_make_it_bright_stupid_header(){
		if( is_active_sidebar( 'upper-right-make-it-bright' ) ){
			echo '</div>';
		}
	}

	/**
	 * Modify Body Classes
	 *
	 * @since 0.9.1
	 * @internal { We want to do a fair amount of CSS work, only if this widget
 	 *	area is active, and sometimes they need to be theme specific. }
	*/
	add_action( 'genesis_meta', 'upper_right_make_it_bright_genesis_meta' );
	function upper_right_make_it_bright_genesis_meta(){
		if( is_active_sidebar( 'upper-right-make-it-bright' ) ){
			add_filter( 'body_class', 'upper_right_make_it_bright_body_class' );
			function upper_right_make_it_bright_body_class( $classes ) {
				$theme = wp_get_theme();

	   			$classes[] = 'upper-right-make-it-bright';
				$classes[] = $theme->stylesheet;
				$classes[] = "theme-{$theme->stylesheet}";

				return $classes;
			}

			add_action( 'genesis_before_header', 'upper_right_make_it_bright_widgets' );
		}
	}

	/**
	 * Custom Preg Replace First Instance Function
	 *
	 * @since 0.9.1
	*/
	function upper_right_make_it_bright_replace_first($from, $to, $subject){
	    $from = '/'.preg_quote($from, '/').'/';
	    return preg_replace($from, $to, $subject, 1);
	}

	/**
	 * Modify Widget Classes and Parameters
	 *
	 * @since 0.4.1
	*/
	add_filter( 'dynamic_sidebar_params', 'upper_right_make_it_bright_sidebar_params' );
	function upper_right_make_it_bright_sidebar_params( $params ) {
	    $sidebar_id	= $params[0]['id'];
	    if ( $sidebar_id == 'upper-right-make-it-bright' ) {
			$total_widgets		= wp_get_sidebars_widgets();
	        $sidebar_widgets	= count( $total_widgets[$sidebar_id] );

			global $widget_counter;
			if ( empty( $widget_counter) ){
				$widget_counter = 1;
			} else {
				$widget_counter++;
			}

			if( $sidebar_widgets == 1 ){
				$col_classes = 'text-lg-right text-md-center text-sm-center';
			}

			if( $sidebar_widgets == 2 ){
				if( $widget_counter == 1 ){
					$col_classes = 'text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 2 ){
					$col_classes = 'text-lg-center text-md-center text-sm-center ';
				}
			}

			if( $sidebar_widgets == 3 ){
				if( $widget_counter == 1 ){
					$col_classes = 'text-lg-left text-md-center text-sm-center ';
				} else if( $widget_counter == 2 ){
					$col_classes = 'text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 3 ){
					$col_classes = 'text-lg-right text-md-center text-sm-center ';
				}
			}

			if( $sidebar_widgets == 4 ){
				if( $widget_counter == 1 ){
					$col_classes = 'text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 2 ){
					$col_classes = 'text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 3 ){
					$col_classes = 'text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 4 ){
					$col_classes = 'text-lg-center text-md-center text-sm-center ';
				}
			}

			$class_col_lg		= floor( 12 / $sidebar_widgets );
			$class_order		= "upper-right-widget-$widget_counter ";

	        $params[0]['before_widget'] = upper_right_make_it_bright_replace_first( 'class="', 'class="upper-right-widget '. $class_order . $col_classes, $params[0]['before_widget'] );
	        $params[0]['before'] = str_replace( '{COLUMNS}', $sidebar_widgets, $params[0]['before'] );
	    }


	    return $params;
	}

	/**
	 * Load Custom Widgets
	 *
	 * @since 0.1
	 * @internal { Add new widgets to `$widgets_array`. Just make sure widgets
 	 *	are located in the /widgets/ folder and named `widget-WIDGET-NAME.php` }
	*/
	add_action( 'after_setup_theme', 'upper_right_load_widgets' );
	function upper_right_load_widgets(){
		$widgets_array = array(
			'call-to-action'
		);

		foreach( $widgets_array as $widget ){
			include( plugin_dir_path( __FILE__ ) . "lib/widgets/widget-$widget.php" );
		}
	}
?>
