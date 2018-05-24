<?php
if ( ! class_exists( 'CI_Events_Widget' ) ):
class CI_Events_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'ci-events', // Base ID
			__( 'Theme - Events', 'oscillator' ), // Name
			array( 'description' => __( 'Display upcoming, past, or recurring events.', 'oscillator' ), ),
			array( /*'width'=> 400, 'height'=> 350*/ )
		);

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$event_category = $instance['event_category'];
		$show_recurring = $instance['show_recurring'] == 1 ? true : false;
		$upcoming_no    = $instance['upcoming_no'];

		$background_color = $instance['background_color'];
		$background_image = $instance['background_image'];
		$parallax         = $instance['parallax'] == 1 ? 'parallax' : '';
		$parallax_speed   = $instance['parallax'] == 1 ? sprintf( 'data-speed="%s"', esc_attr( $instance['parallax_speed'] / 10 ) ) : '';
		$parallax_image   = $instance['parallax'] == 1 && ! empty( $background_image ) ? sprintf( 'data-image-src="%s" data-parallax="scroll" data-bleed="3"', esc_url( $background_image ) ) : '';
		if ( ! empty( $background_color ) || ! empty( $background_image ) ) {
			preg_match( '/class=(["\']).*?widget.*?\1/', $before_widget, $match );
			if ( ! empty( $match ) ) {
				$attr_class    = preg_replace( '/\bwidget\b/', 'widget widget-padded', $match[0], 1 );
				$before_widget = str_replace( $match[0], $attr_class, $before_widget );
			}
		}

		echo $before_widget;

		?><div class="widget-wrap <?php echo esc_attr( $parallax ); ?>" <?php echo $parallax_speed; ?> <?php echo $parallax_image; ?>><?php

		$recurrent_params = array();
		$upcoming_params  = array();

		if( $show_recurring ) {
			$recurrent_params = array(
				'post_type'      => 'oscillator_event',
				'posts_per_page' => - 1,
				'meta_key'       => 'oscillator_event_recurrence',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'     => 'oscillator_event_recurrent',
						'value'   => 1,
						'compare' => '='
					)
				)
			);
		}

		if( $upcoming_no > 0 ) {
			$upcoming_params = array(
				'post_type'      => 'oscillator_event',
				'posts_per_page' => intval( $upcoming_no ),
				'meta_query'     => array(
					'relation' => 'AND',
					'date_clause' => array(
						'key'     => 'oscillator_event_date',
						'value'   => date_i18n('Y-m-d'),
						'compare' => '>=',
						'type'    => 'DATE'
					),
					'time_clause' => array(
						'key'     => 'oscillator_event_time',
						'compare' => 'EXISTS',
						'type'    => 'TIME'
					),
				),
				'orderby'        => array(
					'date_clause' => 'ASC',
					'time_clause' => 'ASC',
				),
			);
		}

		$args_tax = array(
			'tax_query' => array(
				array(
					'taxonomy'         => 'oscillator_event_category',
					'field'            => 'id',
					'terms'            => intval( $event_category ),
					'include_children' => true
				)
			)
		);


		if ( ! empty( $event_category ) && $event_category >= 1 ) {
			$recurrent_params = array_merge( $recurrent_params, $args_tax );
			$upcoming_params  = array_merge( $upcoming_params, $args_tax );
		}

		$events = false;
		if ( $show_recurring == true && $upcoming_no > 0 ) {
			$events = oscillator_merge_wp_queries( $recurrent_params, $upcoming_params );
		} elseif ( $show_recurring ) {
			$events = new WP_Query( $recurrent_params );
		} elseif ( $upcoming_no > 0 ) {
			$events = new WP_Query( $upcoming_params );
		}


		if ( in_array( $id, oscillator_get_fullwidth_sidebars() ) ) {
			?><div class="container"><?php
		}

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		?>
		<div class="row">
		<div class="col-xs-12"><?php

		if( $events->have_posts() ) {
			?><ul class="list-array"><?php

			while ( $events->have_posts() ) {
				$events->the_post();
				get_template_part( 'item', get_post_type() );
			}
			wp_reset_postdata();

			?></ul><?php
		}

		?></div>
		</div>
		<?php

		if ( in_array( $id, oscillator_get_fullwidth_sidebars() ) ) {
			?></div><?php
		}

		?></div><?php

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title']          = sanitize_text_field( $new_instance['title'] );
		$instance['event_category'] = intval( $new_instance['event_category'] );
		$instance['show_recurring'] = oscillator_sanitize_checkbox_ref( $new_instance['show_recurring'] );
		$instance['upcoming_no']    = absint( $new_instance['upcoming_no'] );

		$instance['color']             = oscillator_sanitize_hex_color( $new_instance['color'] );
		$instance['background_color']  = oscillator_sanitize_hex_color( $new_instance['background_color'] );
		$instance['background_image']  = esc_url_raw( $new_instance['background_image'] );
		$instance['background_repeat'] = in_array( $new_instance['background_repeat'], array( 'repeat', 'no-repeat', 'repeat-x', 'repeat-y' ) ) ? $new_instance['background_repeat'] : 'repeat';
		$instance['parallax']          = oscillator_sanitize_checkbox_ref( $new_instance['parallax'] );
		$instance['parallax_speed']    = absint( $new_instance['parallax_speed'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'          => '',
			'event_category' => '',
			'show_recurring' => 1,
			'upcoming_no'    => 3,
			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
			'parallax'          => '',
			'parallax_speed'    => 4,
		) );

		$title          = $instance['title'];
		$event_category = $instance['event_category'];
		$show_recurring = $instance['show_recurring'];
		$upcoming_no    = $instance['upcoming_no'];

		$color             = $instance['color'];
		$background_color  = $instance['background_color'];
		$background_image  = $instance['background_image'];
		$background_repeat = $instance['background_repeat'];
		$parallax          = $instance['parallax'];
		$parallax_speed    = $instance['parallax_speed'];
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p>

		<p><label for="<?php echo $this->get_field_id( 'event_category' ); ?>"><?php esc_html_e( 'Base category:', 'oscillator' ); ?></label>
		<?php wp_dropdown_categories( array(
			'selected'          => $event_category,
			'id'                => $this->get_field_id( 'event_category' ),
			'name'              => $this->get_field_name( 'event_category' ),
			'class'             => 'widefat',
			'show_option_none'  => ' ',
			'option_none_value' => 0,
			'taxonomy'          => 'oscillator_event_category',
			'hierarchical'      => 1,
			'show_count'        => 1,
			'hide_empty'        => 0
		) ); ?></p>

		<p><label><input type="checkbox" name="<?php echo $this->get_field_name( 'show_recurring' ); ?>" id="<?php echo $this->get_field_id( 'show_recurring' ); ?>" value="1" <?php checked( $show_recurring, 1 ); ?> /><?php esc_html_e( 'Show recurring events.', 'oscillator' ); ?></label></p>
		<p><label for="<?php echo $this->get_field_id( 'upcoming_no' ); ?>"><?php esc_html_e( 'Number of upcoming events (0 to disable):', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'upcoming_no' ); ?>" name="<?php echo $this->get_field_name( 'upcoming_no' ); ?>" type="number" step="1" min="0" value="<?php echo esc_attr( $upcoming_no ); ?>" class="widefat"/></p>

		<fieldset class="ci-collapsible">
			<legend><?php esc_html_e( 'Custom Colors', 'oscillator' ); ?> <i class="dashicons dashicons-arrow-down"></i></legend>
			<div class="elements">
				<p><label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php esc_html_e( 'Foreground Color:', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo esc_attr( $color ); ?>" class="colorpckr widefat"/></p>
				<p><label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php esc_html_e( 'Background Color:', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" value="<?php echo esc_attr( $background_color ); ?>" class="colorpckr widefat"/></p>

				<p class="ci-collapsible-media"><label for="<?php echo $this->get_field_id( 'background_image' ); ?>"><?php esc_html_e( 'Background Image:', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" type="text" value="<?php echo esc_attr( $background_image ); ?>" class="ci-uploaded-url widefat"/><a href="#" class="button ci-media-button"><?php esc_html_e( 'Upload', 'oscillator' ); ?></a></p>
				<p>
					<label for="<?php echo $this->get_field_id( 'background_repeat' ); ?>"><?php esc_html_e( 'Background Repeat:', 'oscillator' ); ?></label>
					<select id="<?php echo $this->get_field_id( 'background_repeat' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'background_repeat' ); ?>">
						<option value="repeat" <?php selected( 'repeat', $background_repeat ); ?>><?php esc_html_e( 'Repeat', 'oscillator' ); ?></option>
						<option value="repeat-x" <?php selected( 'repeat-x', $background_repeat ); ?>><?php esc_html_e( 'Repeat Horizontally', 'oscillator' ); ?></option>
						<option value="repeat-y" <?php selected( 'repeat-y', $background_repeat ); ?>><?php esc_html_e( 'Repeat Vertically', 'oscillator' ); ?></option>
						<option value="no-repeat" <?php selected( 'no-repeat', $background_repeat ); ?>><?php esc_html_e( 'No Repeat', 'oscillator' ); ?></option>
					</select>
				</p>

				<p><label for="<?php echo $this->get_field_id( 'parallax' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'parallax' ); ?>" id="<?php echo $this->get_field_id( 'parallax' ); ?>" value="1" <?php checked( $parallax, 1 ); ?> /><?php esc_html_e( 'Parallax effect (requires a background image).', 'oscillator' ); ?></label></p>
				<p><label for="<?php echo $this->get_field_id( 'parallax_speed' ); ?>"><?php esc_html_e( 'Parallax speed (1-10):', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'parallax_speed' ); ?>" name="<?php echo $this->get_field_name( 'parallax_speed' ); ?>" type="number" min="1" max="10" step="1" value="<?php echo esc_attr( $parallax_speed ); ?>" class="widefat"/></p>

			</div>
		</fieldset>

		<?php
	} // form

	function enqueue_custom_css() {
		$settings = $this->get_settings();

		if ( empty( $settings ) ) {
			return;
		}

		foreach ( $settings as $instance_id => $instance ) {
			$id = $this->id_base . '-' . $instance_id;

			if ( ! is_active_widget( false, $id, $this->id_base ) ) {
				continue;
			}

			$sidebar_id      = false; // Holds the sidebar id that the widget is assigned to.
			$sidebar_widgets = wp_get_sidebars_widgets();
			if ( ! empty( $sidebar_widgets ) ) {
				foreach ( $sidebar_widgets as $sidebar => $widgets ) {
					// We need to check $widgets for emptiness due to https://core.trac.wordpress.org/ticket/14876
					if ( ! empty( $widgets ) && array_search( $id, $widgets ) !== false ) {
						$sidebar_id = $sidebar;
					}
				}
			}

			$color             = $instance['color'];
			$background_color  = $instance['background_color'];
			$background_image  = $instance['background_image'];
			$background_repeat = $instance['background_repeat'];

			$css         = '';
			$padding_css = '';

			if ( ! empty( $color ) ) {
				$css .= 'color: ' . $color . '; ';
			}
			if ( ! empty( $background_color ) ) {
				$css .= 'background-color: ' . $background_color . '; ';
			}
			if ( ! empty( $background_image ) ) {
				$css .= 'background-image: url(' . esc_url( $background_image ) . ');';
				$css .= 'background-repeat: ' . $background_repeat . ';';
			}

			if ( ! empty( $css ) || ! empty( $padding_css ) ) {
				$css = '#' . $id . ' .widget-wrap { ' . $css . $padding_css . ' } ' . PHP_EOL;
				wp_add_inline_style( 'oscillator-style', $css );
			}

		}

	}
}


register_widget( 'CI_Events_Widget' );

endif;