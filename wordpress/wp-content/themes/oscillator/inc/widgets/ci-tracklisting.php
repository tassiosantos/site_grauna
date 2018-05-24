<?php
/**
 * Tracklisting Widget.
 */
if ( ! class_exists( 'CI_Tracklisting_Widget' ) ):
class CI_Tracklisting_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'ci-tracklisting', // Base ID
			__( 'Theme - Tracklisting', 'oscillator' ), // Name
			array( 'description' => __( "Display a discography's track listing.", 'oscillator' ), ),
			array( /*'width'=> 400, 'height'=> 350*/ )
		);

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$post_id    = $instance['post_id'];
		$show_image = isset( $instance['show_image'] ) && $instance['show_image'] == 1 ? 1 : 0;

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

		$q = new WP_Query( array(
			'post_type' => 'oscillator_disco',
			'p'         => $post_id
		) );

		if ( in_array( $id, oscillator_get_fullwidth_sidebars() ) ) {
			?><div class="container"><?php
		}

		while ( $q->have_posts() ) {
			$q->the_post();

			if ( ! empty( $title ) ) {
				echo $before_title . $title . $after_title;
			} else {
				echo $before_title . get_the_title() . $after_title;
			}

			?><div class="row"><?php

			$tracks_class = 'col-xs-12';
			if( $show_image ) {
				$tracks_class = 'col-md-8 col-sm-12 col-xs-12';
				?>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<?php get_template_part( 'item', get_post_type() ); ?>
				</div>
				<?php
			}
			?>
			<div class="<?php echo esc_attr( $tracks_class ); ?>">
				<?php
					if ( in_array( $id, oscillator_get_fullwidth_sidebars() ) ) {
						echo do_shortcode( '[tracklisting id="' . esc_attr( $post_id ) . '"]' );
					} else {
						echo do_shortcode( '[tracklisting id="' . esc_attr( $post_id ) . '" lyrics="false" buy="false" download="false"]' );
					}
				?>
			</div>
			<?php

			?></div><?php
		}

		wp_reset_postdata();

		if ( in_array( $id, oscillator_get_fullwidth_sidebars() ) ) {
			?></div><?php
		}

		?></div><?php

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title']      = sanitize_text_field( $new_instance['title'] );
		$instance['post_id']    = absint( $new_instance['post_id'] );
		$instance['show_image'] = oscillator_sanitize_checkbox_ref( $new_instance['show_image'] );

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
			'title'             => '',
			'post_id'           => '',
			'show_image'        => 1,
			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
			'parallax'          => '',
			'parallax_speed'    => 4,
		) );

		$title      = $instance['title'];
		$post_id    = $instance['post_id'];
		$show_image = $instance['show_image'];

		$color             = $instance['color'];
		$background_color  = $instance['background_color'];
		$background_image  = $instance['background_image'];
		$background_repeat = $instance['background_repeat'];
		$parallax          = $instance['parallax'];
		$parallax_speed    = $instance['parallax_speed'];
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title (optional):', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php esc_html_e( 'Select Discography Item:', 'oscillator' ); ?></label>
			<?php oscillator_dropdown_posts( array(
				'post_type'            => 'oscillator_disco',
				'selected'             => $post_id,
				'class'                => 'widefat',
				'select_even_if_empty' => true,
			), $this->get_field_name( 'post_id' ) ); ?>
		</p>
		<p><label><input type="checkbox" name="<?php echo $this->get_field_name( 'show_image' ); ?>" id="<?php echo $this->get_field_id( 'show_image' ); ?>" value="1" <?php checked( $show_image, 1 ); ?> /><?php esc_html_e( 'Show album image.', 'oscillator' ); ?></label></p>

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


register_widget( 'CI_Tracklisting_Widget' );

endif;