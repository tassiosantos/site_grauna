<?php 
if ( ! class_exists( 'CI_Latest_Post_Type_Widget' ) ):
class CI_Latest_Post_Type_Widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array( 'description' => __( 'Displays a number of the latest (or random) posts from a specific post type.', 'oscillator' ) );
		$control_ops = array();
		parent::__construct( 'ci-latest-post-type', __( 'Theme - Latest Post Type', 'oscillator' ), $widget_ops, $control_ops );

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
	}


	function widget($args, $instance) {
		extract($args);
		$title     = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$post_type = $instance['post_type'];
		$random    = $instance['random'];
		$count     = $instance['count'];

		global $columns;
		$columns = $instance['columns'];

		if ( 0 == $count ) {
			return;
		}

		$item_classes = oscillator_get_columns_classes( $columns );

		$args = array(
			'post_type'      => $post_type,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => $count
		);

		if ( 1 == $random ) {
			$args['orderby'] = 'rand';
			unset( $args['order'] );
		}

		$q = new WP_Query( $args );


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

		if ( in_array( $id, oscillator_get_fullwidth_sidebars() ) ) {
			?><div class="container"><?php
		}

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		?><div class="row row-joined item-list"><?php

			while( $q->have_posts() ) {
				$q->the_post();
				?>
				<div class="<?php echo esc_attr( $item_classes ); ?>">
					<?php get_template_part( 'item', get_post_type() ); ?>
				</div>
				<?php
			}
			wp_reset_postdata();

		?></div><?php

		wp_reset_postdata();

		if ( in_array( $id, oscillator_get_fullwidth_sidebars() ) ) {
			?></div><?php
		}

		?></div><?php

		echo $after_widget;

	} // widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['post_type'] = sanitize_key( $new_instance['post_type'] );
		$instance['random']    = oscillator_sanitize_checkbox_ref( $new_instance['random'] );
		$instance['count']     = intval( $new_instance['count'] );
		$instance['columns']   = intval( $new_instance['columns'] );

		$instance['color']             = oscillator_sanitize_hex_color( $new_instance['color'] );
		$instance['background_color']  = oscillator_sanitize_hex_color( $new_instance['background_color'] );
		$instance['background_image']  = esc_url_raw( $new_instance['background_image'] );
		$instance['background_repeat'] = in_array( $new_instance['background_repeat'], array( 'repeat', 'no-repeat', 'repeat-x', 'repeat-y' ) ) ? $new_instance['background_repeat'] : 'repeat';
		$instance['parallax']          = oscillator_sanitize_checkbox_ref( $new_instance['parallax'] );
		$instance['parallax_speed']    = absint( $new_instance['parallax_speed'] );

		return $instance;
	} // save

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'     => '',
			'post_type' => 'post',
			'random'    => '',
			'count'     => 3,
			'columns'   => 3,
			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
			'parallax'          => '',
			'parallax_speed'    => 4,
		) );

		$title     = $instance['title'];
		$post_type = $instance['post_type'];
		$random    = $instance['random'];
		$count     = $instance['count'];
		$columns   = $instance['columns'];

		$color             = $instance['color'];
		$background_color  = $instance['background_color'];
		$background_image  = $instance['background_image'];
		$background_repeat = $instance['background_repeat'];
		$parallax          = $instance['parallax'];
		$parallax_speed    = $instance['parallax_speed'];

		?><p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p><?php

		$types = get_post_types( $args = array(
			'public' => true
		), 'objects' );
		unset( $types['attachment'], $types['oscillator_event'] );

		?>
		<p><label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php esc_html_e( 'Select a post type to display the latest post from', 'oscillator' ); ?></label>
		<select id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
			<?php foreach ( $types as $key => $type ): ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $post_type, $key ); ?>>
					<?php echo esc_html( $type->labels->name ); ?>
				</option>
			<?php endforeach; ?>
		</select></p>

		<p><label for="<?php echo $this->get_field_id( 'random' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'random' ); ?>" id="<?php echo $this->get_field_id( 'random' ); ?>" value="1" <?php checked( $random, 1 ); ?> /><?php esc_html_e( 'Show random posts.', 'oscillator' ); ?></label></p>
		<p><label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php esc_html_e( 'Number of posts to show:', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" min="1" step="1" value="<?php echo esc_attr( $count ); ?>" class="widefat"/></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php esc_html_e( 'Output Columns:', 'oscillator' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'columns' ); ?>" name="<?php echo $this->get_field_name( 'columns' ); ?>">
				<?php for ( $i = 2; $i <= 4; $i ++ ) {
					echo sprintf( '<option value="%s" %s>%s</option>',
						esc_attr( $i ),
						selected( $columns, $i, false ),
						esc_html( sprintf( _n( '1 Column', '%s Columns', $i, 'oscillator' ), $i ) )
					);
				} ?>
			</select>
		</p>

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

} // class

register_widget( 'CI_Latest_Post_Type_Widget' );

endif;