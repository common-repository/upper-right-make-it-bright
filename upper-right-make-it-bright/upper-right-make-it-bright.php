<?php
	/**
	 * Plugin Name: Upper Right, Make It Bright
	 * Description: This plugin adds a section to allow users to add things to the upper right, and make them bright!
	 * @version:	Br.1.ght
	 * @author:		The Upper Right Fairy
	 * @package:	Plugin
	 * @subpackage:	UR, MIB
	 *
	*/

	add_action( 'wp_enqueue_scripts', 'upper_right_make_it_bright_front_css' );
	function upper_right_make_it_bright_front_css(){
		//JS
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'upper-right-make-it-bright', plugins_url( '/assets/js/upper-right-make-it-bright.js', __FILE__ ), array('jquery'), '', true );

		//CSS
		wp_register_style( 'upper-right-make-it-bright', plugins_url( '/assets/css/upper-right-make-it-bright.css', __FILE__ ) );
		wp_enqueue_style( 'upper-right-make-it-bright' );
	}

	add_action( 'genesis_setup', 'upper_right_make_it_bright_genesis_sidebar' );
	function upper_right_make_it_bright_genesis_sidebar(){
		if( function_exists( 'genesis_register_sidebar' ) ){
			genesis_register_sidebar( array(
				'id'          => 'upper-right-make-it-bright',
				'name'        => __( 'Upper Right, Make It Bright', 'urmib' ),
				'description' => __( 'This section allows you to add items to the upper right, and make them bright.', 'urmib' ),
			) );
		}
	}

	function upper_right_make_it_bright_widgets() {
		if( function_exists( 'genesis_widget_area' ) ){
			genesis_widget_area( 'upper-right-make-it-bright', array(
				'before' => '<div class="site-header"><div id="brightness-over-9000" class="brightness-over-9000"><div class="row">',
				'after'  => '</div><div class="clear-both"></div></div>',
			) );
		}
	}

	add_action( 'genesis_after_header', 'upper_right_make_it_bright_stupid_header' );
	function upper_right_make_it_bright_stupid_header(){
		if( is_active_sidebar( 'upper-right-make-it-bright' ) ){
			echo '</div>';
		}
	}

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

	function upper_right_make_it_bright_replace_first($from, $to, $subject){
	    $from = '/'.preg_quote($from, '/').'/';
	    return preg_replace($from, $to, $subject, 1);
	}

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
				$col_classes = 'col-lg-12 col-md-12 col-sm-12 text-lg-right text-md-center text-sm-center ';
			}

			if( $sidebar_widgets == 2 ){
				if( $widget_counter == 1 ){
					$col_classes = 'col-lg-6 col-md-6 col-sm-12 text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 2 ){
					$col_classes = 'col-lg-6 col-md-6 col-sm-12 text-lg-center text-md-center text-sm-center ';
				}
			}

			if( $sidebar_widgets == 3 ){
				if( $widget_counter == 1 ){
					$col_classes = 'col-lg-4 col-md-6 col-sm-12 text-lg-left text-md-center text-sm-center ';
				} else if( $widget_counter == 2 ){
					$col_classes = 'col-lg-4 col-md-6 col-sm-12 text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 3 ){
					$col_classes = 'col-lg-4 col-md-12 col-sm-12 text-lg-right text-md-center text-sm-center ';
				}
			}

			if( $sidebar_widgets == 4 ){
				if( $widget_counter == 1 ){
					$col_classes = 'col-lg-3 col-md-6 col-sm-12 text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 2 ){
					$col_classes = 'col-lg-3 col-md-6 col-sm-12 text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 3 ){
					$col_classes = 'col-lg-3 col-md-6 col-sm-12 text-lg-center text-md-center text-sm-center ';
				} else if( $widget_counter == 4 ){
					$col_classes = 'col-lg-3 col-md-6 col-sm-12 text-lg-center text-md-center text-sm-center ';
				}
			}

			$class_col_lg		= floor( 12 / $sidebar_widgets );
			$class_order		= "upper-right-widget-$widget_counter ";

	        $params[0]['before_widget'] = upper_right_make_it_bright_replace_first( 'class="', 'class="upper-right-widget '. $class_order . $col_classes, $params[0]['before_widget'] );
	    }
	    return $params;
	}

	// Load Widgets
	add_action( 'after_setup_theme', 'upper_right_load_widgets' );
	function upper_right_load_widgets(){
		// Call to Action
		include( plugin_dir_path( __FILE__ ) . 'lib/widgets/widget-call-to-action.php' );
	}
?>
