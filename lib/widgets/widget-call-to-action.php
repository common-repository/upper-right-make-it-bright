<?php
	/**
	 * Redbrick Digital Core
	 *
	 * @package \lib\widgets
	 * @author  RedbrickDigital.net
	 * @license GPL-2.0+
	 * @since 0.2.1
	 *
	 *        (\ /)
	 *       ( . .) ♥ ~< Creates a Call to Action, mobile-friendly widget! >
	 *       c(”)(”)
	*/

	/**
	 * Define Options As Array
	 *
	 * @since 0.2
	*/
	function upper_right_call_to_action_array(){
		if( function_exists( 'genesis_get_option' ) ){
			$array = array(
				//'text_align'	=> 'right',
				'title'						=> 'Call Today:',
				'address'					=> genesis_get_option( 'lmp_gen_street_address', 'website-genesis-options' ) .' '. genesis_get_option( 'lmp_gen_street_address_two', 'website-genesis-options') .', '. genesis_get_option( 'lmp_gen_city', 'website-genesis-options') .', '. genesis_get_option( 'lmp_gen_state', 'website-genesis-options') .' '. genesis_get_option( 'lmp_gen_zip_code', 'website-genesis-options'),
				//'company_name'			=> genesis_get_option( 'lmp_gen_company_name', 'website-genesis-options' ),
				'phone_number'				=> genesis_get_option( 'lmp_gen_phone', 'website-genesis-options' ),
				'hide_directions'			=> 0,
				'click_to_call_text'		=> 'Call Today',
				'click_for_directions_text'	=> 'Directions',
			);

			return $array;
		}
	}

	/**
	 * Construct Widget
	 *
	 * @since 0.2
	*/
	class upper_right_mib_call_to_action extends WP_Widget {

		function __construct() {
			parent::__construct(
				# Widget Base ID
				'upper_right_mib_call_to_action',

				# Widget Display Name
				__('Call to Action ↗ (Upper Right)', 'upper_right_mib_call_to_action_domain'),

				# Widget Description
				array( 'description' => __( 'Display a "Call Today" phone number that turns to a click-to-call button on mobile.', 'upper_right_mib_call_to_action_domain' ), )
			);
		}

		/**
		 * Widget Front-End Parsing
		 *
		 * @since 0.2
		*/
		public function widget( $args, $instance ) {
			$array = upper_right_call_to_action_array();
			foreach( $array as $var => $default_value){
				${$var} = apply_filters( 'widget_'.$var, $instance[$var] );
			}

			$_phone_number	= preg_replace( '~\D~', '', $phone_number );
			$_google_maps	= str_replace( ' ', '+', $address );

			# before and after widget arguments are defined by themes
			echo $args['before_widget']; ?>
				<div class="upper-right-core-ui">
					<div class="upper-right-call-to-action">
						<div class="show-lg block large"><?php echo $title; ?> <strong><?php echo $phone_number; ?></strong></div>
						<div class="hide-lg block">
							<a class="call-to-action button dib" <?php if( $hide_directions == true ){ echo 'style="margin-right: 0 !important;"'; } ?> href="tel:<?php echo $_phone_number; ?>"><span><i class="fa fa-2x fa-mobile"></i><?php echo $click_to_call_text; ?></span></a>
							<?php if( $hide_directions != true ){ ?>
								<a class="call-to-action button dib" href="https://www.google.com/maps/place/<?php echo $_google_maps; ?>"><span><i class="fa fa-2x fa-map-marker"></i><?php echo $click_for_directions_text; ?></span></a>
							<?php } ?>
						</div>
						<!--<div class=""><a href="tel:1234567890">Call Today</a>-->
					</div>
				</div>
			<?php echo $args['after_widget'];
		}

		/**
		 * Widget Back-End Form
		 *
		 * @since 0.2
		*/
		public function form( $instance ) {
			$array = upper_right_call_to_action_array();
			foreach( $array as $var => $default_value){
				${$var} = isset( $instance[$var] ) ? $instance[$var] : $default_value;
			}

			# Widget admin form
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

				<div style="clear: both;"></div>

				<p style="width: 47.5%; margin: 0 -4px 0 0; display: inline-block; margin-bottom: 1em;">
					<strong><label for="<?php echo $this->get_field_id( 'click_to_call_text' ); ?>"><?php _e( 'Call Today Label:' ); ?></label></strong><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'click_to_call_text' ); ?>" name="<?php echo $this->get_field_name( 'click_to_call_text' ); ?>" type="text" value="<?php echo esc_attr( $click_to_call_text ); ?>" />
				</p>

				<p style="width: 47.5%; margin: 0 -4px 0 5%; display: inline-block; margin-bottom: 1em;">
					<strong><label for="<?php echo $this->get_field_id( 'click_for_directions_text' ); ?>"><?php _e( 'Directions Label:' ); ?></label></strong><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'click_for_directions_text' ); ?>" name="<?php echo $this->get_field_name( 'click_for_directions_text' ); ?>" type="text" value="<?php echo esc_attr( $click_for_directions_text ); ?>" />
				</p>

				<div style="clear: both;"></div>

				<p style="width: 47.5%; margin: 0 -4px 0 0; display: inline-block; margin-bottom: 1em;">
					<strong>
						<label for="<?php echo $this->get_field_id( 'hide_directions' ); ?>"><?php _e( 'Hide Directions Button:' ); ?></label><br />
						<input class="widefat" id="<?php echo $this->get_field_id( 'hide_directions' ); ?>" name="<?php echo $this->get_field_name( 'hide_directions' ); ?>" type="checkbox" <?php if( $hide_directions == true ){ echo 'checked="checked"'; } ?> value="1" />
					</strong>
				</p>
				<p style="width: 47.5%; margin: 0 -4px 0 5%; display: inline-block; margin-bottom: 1em;">
					<strong><label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Street Address:' ); ?></label></strong><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo esc_attr( $address ); ?>" />
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

		/**
		 * Update Old Instance With New, Saving Function
		 *
		 * @since 0.2
		*/
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$array = upper_right_call_to_action_array();
			foreach( $array as $var => $default_value){
				$instance[$var] = ( !empty( $new_instance[$var] ) ) ? sanitize_text_field( $new_instance[$var] ) : '';
			}

			return $instance;
		}
	}

	/**
	 * Register and Load Widget
	 *
	 * @since 0.2
	*/
	function rbd_load_widget_upper_right_mib_call_to_action() {
		register_widget( 'upper_right_mib_call_to_action' );
	}
	add_action( 'widgets_init', 'rbd_load_widget_upper_right_mib_call_to_action' );
?>
