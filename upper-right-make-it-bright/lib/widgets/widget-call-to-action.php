<?php
	// Instead of redefining these 3 or 4 times, each function will loop through this array.
	function rbd_core_definitions_array_upper_right_mib_call_to_action(){
		$array = array(
			'title'			=> 'Call Today:',
			'text_align'	=> 'right',
			'phone_number'	=> genesis_get_option('lmp_gen_phone', 'website-genesis-options'),
		);

		return $array;
	}

	// Creating the widget
	class upper_right_mib_call_to_action extends WP_Widget {

		function __construct() {
			parent::__construct(
			// Base ID of your widget
			'upper_right_mib_call_to_action',

			// Widget name will appear in UI
			__('Call to Action ↗ (Upper Right)', 'upper_right_mib_call_to_action_domain'),

			// Widget description
			array( 'description' => __( 'Display a "Call Today" phone number that turns to a click-to-call button on mobile.', 'upper_right_mib_call_to_action_domain' ), )
			);
		}

		// Widget Frontend
		public function widget( $args, $instance ) {
			$array = rbd_core_definitions_array_upper_right_mib_call_to_action();
			foreach( $array as $var => $default_value){
				${$var} = apply_filters( 'widget_'.$var, $instance[$var] );
			}

			// before and after widget arguments are defined by themes
			echo $args['before_widget']; ?>
				<div class="upper-right-core-ui">
					<div class="upper-right-call-to-action">
						<div class="visible-lg large"><?php echo $title; ?> <strong><?php echo $phone_number; ?></strong></div>
						<div class="hidden-lg">
							<a class="call-to-action dib" href="#">Call Today</a>
							<a class="call-to-action dib" href="#">Find Us</a>
						</div>
						<!--<div class=""><a href="tel:1234567890">Call Today</a>-->
					</div>
				</div>
			<?php echo $args['after_widget'];
		}

		// Widget Backend
		public function form( $instance ) {
			$array = rbd_core_definitions_array_upper_right_mib_call_to_action();
			foreach( $array as $var => $default_value){
				${$var} = isset( $instance[$var] ) ? $instance[$var] : $default_value;
			}

			// Widget admin form
			?>
			<div class="rbd-core-ui-admin">
				<p style="width: 47.5%; margin: 0 -4px 0 0; display: inline-block; margin-bottom: 1em;">
					<strong><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label></strong>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				<p style="width: 47.5%; margin: 0 -4px 0 5%; display: inline-block; margin-bottom: 1em;">
					<strong><label for="<?php echo $this->get_field_id( 'phone_number' ); ?>"><?php _e( 'Phone Number:' ); ?></label></strong><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'phone_number' ); ?>" name="<?php echo $this->get_field_name( 'phone_number' ); ?>" type="text" value="<?php echo esc_attr( $phone_number ); ?>" />
				</p>
				<?php /*
				<p style="width: 30%; margin: 0 0 0 5%; display: inline-block; margin-bottom: 1em;">
					<strong><label for="<?php echo $this->get_field_id( 'text_align' ); ?>"><?php _e( 'Alignment:' ); ?></label></strong>
					<select class="widefat" id="<?php echo $this->get_field_id( 'text_align' ); ?>" name="<?php echo $this->get_field_name( 'text_align' ); ?>">
						<option <?php if($text_align == 'left'){	echo 'selected="selected"'; } ?> value="left">Left</option>
						<option <?php if($text_align == 'center'){	echo 'selected="selected"'; } ?> value="center">Center</option>
						<option <?php if($text_align == 'right'){	echo 'selected="selected"'; } ?> value="right">Right</option>
					</select>
				</p> */ ?>
			</div>
		<?php }

		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$array = rbd_core_definitions_array_upper_right_mib_call_to_action();
			foreach( $array as $var => $default_value){
				$instance[$var] = ( !empty( $new_instance[$var] ) ) ? sanitize_text_field( $new_instance[$var] ) : '';
			}

			return $instance;
		}
	} // Class upper_right_mib_call_to_action ends here

	// Register and load the widget
	function rbd_load_widget_upper_right_mib_call_to_action() {
		register_widget( 'upper_right_mib_call_to_action' );
	}
	add_action( 'widgets_init', 'rbd_load_widget_upper_right_mib_call_to_action' );
?>
