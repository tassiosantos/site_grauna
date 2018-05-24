<?php
if ( ! class_exists( 'CI_Items_Widget' ) ):
class CI_Items_Widget extends WP_Widget {

	public $ajax_action = 'ci_items_widget_post_type_ajax_get_posts';

	function __construct() {
		$widget_ops  = array( 'description' => __( 'Displays a hand-picked selection of posts from a selected post type.', 'oscillator' ) );
		$control_ops = array();
		parent::__construct( 'ci-items', $name = __( 'Theme - Items', 'oscillator' ), $widget_ops, $control_ops );

		if ( is_admin() === true ) {
			add_action( 'wp_ajax_' . $this->ajax_action, 'CI_Items_Widget::_ajax_get_posts' );
		}

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$types = $instance['post_types'];
		$ids   = $instance['postids'];
		$count = max( count( $types ), count( $ids ) );

		global $columns;
		$columns = $instance['columns'];

		$item_classes = oscillator_get_columns_classes( $columns );

		if ( empty( $types ) or empty( $ids ) ) {
			return;
		}


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

			for ( $i = 0; $i < $count; $i++ ) {
				$pid       = $ids[ $i ];
				$post_type = $types[ $i ];

				$q = new WP_Query( array(
					'post_type' => $post_type,
					'p'         => $pid
				) );

				while( $q->have_posts() ) {
					$q->the_post();
					?>
					<div class="<?php echo esc_attr( $item_classes ); ?>">
						<?php get_template_part( 'item', get_post_type() ); ?>
					</div>
					<?php
				}
				wp_reset_postdata();
			}

		?></div><?php

		if ( in_array( $id, oscillator_get_fullwidth_sidebars() ) ) {
			?></div><?php
		}

		?></div><?php

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		// Sanitize repeating fields. Remove empty entries.
		$instance['post_types'] = array();
		$instance['postids']    = array();

		$types = $new_instance['post_types'];
		$ids   = $new_instance['postids'];
		$count = max( count( $types ), count( $ids ) );

		for ( $i = 0; $i < $count; $i ++ ) {
			if ( ! empty( $types[ $i ] ) && ! empty( $ids[ $i ] ) ) {
				$instance['post_types'][] = sanitize_key( $types[ $i ] );
				$instance['postids'][]    = absint( $ids[ $i ] );
			}
		}

		$instance['columns'] = intval( $new_instance['columns'] );

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
			'title'      => '',
			'post_types' => array(),
			'postids'    => array(),
			'columns'    => 3,
			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
			'parallax'          => '',
			'parallax_speed'    => 4,
		) );

		$title      = $instance['title'];
		$post_types = $instance['post_types'];
		$postids    = $instance['postids'];
		$columns    = $instance['columns'];

		$color             = $instance['color'];
		$background_color  = $instance['background_color'];
		$background_image  = $instance['background_image'];
		$background_repeat = $instance['background_repeat'];
		$parallax          = $instance['parallax'];
		$parallax_speed    = $instance['parallax_speed'];

		?><p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'oscillator' ); ?></label><input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p><?php

		$post_types_available = get_post_types( array( 'public' => true ), 'objects' );
		unset( $post_types_available['attachment'], $post_types_available['oscillator_event'] );

		$posttypes_name = $this->get_field_name( 'post_types' ) . '[]';
		$ids_name       = $this->get_field_name( 'postids' ) . '[]';

		?>
		<p><?php _e( 'Add as many items as you want by pressing the "Add Item" button. Remove any item by selecting "Remove me".', 'oscillator' ); ?></p>
		<fieldset class="ci-repeating-fields ci-items">
			<div class="inner">
				<?php
					if ( ! empty( $postids ) && ! empty( $post_types ) ) {
						$count = max( count( $postids ), count( $post_types ) );
						for( $i = 0; $i < $count; $i++ ) {
							?>
							<div class="post-field" data-ajaxaction="<?php echo esc_attr( $this->ajax_action ); ?>">
								<label class="post-field-type"><?php esc_html_e( 'Post type:', 'oscillator' ); ?>
									<select name="<?php echo esc_attr( $posttypes_name ); ?>" class="widefat posttype_dropdown">
										<?php
											foreach( $post_types_available as $key => $pt ) {
												?><option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $post_types[ $i ] ); ?>><?php echo esc_html( $pt->labels->name ); ?></option><?php
											}
										?>
									</select>
								</label>
								<label class="post-field-item"><?php esc_html_e( 'Item:', 'oscillator' ); ?>
									<?php
										oscillator_dropdown_posts( array(
											'post_type'            => $post_types[ $i ],
											'selected'             => $postids[ $i ],
											'class'                => 'widefat posts_dropdown',
											'show_option_none'     => '&nbsp;',
											'select_even_if_empty' => true,
										), $ids_name );
									?>
								</label>
								<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php _e( 'Remove me', 'oscillator' ); ?></a></p>
							</div>
							<?php
						}
					}
				?>
				<?php
				//
				// Add an empty and hidden set for jQuery
				//
				?>
				<div class="post-field field-prototype" style="display: none;" data-ajaxaction="<?php echo esc_attr( $this->ajax_action ); ?>">
					<label class="post-field-type"><?php esc_html_e( 'Post type:', 'oscillator' ); ?>
						<select name="<?php echo esc_attr( $posttypes_name ); ?>" class="widefat posttype_dropdown">
							<?php
								foreach ( $post_types_available as $key => $pt ) {
									?><option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $pt->labels->name ); ?></option><?php
								}
							?>
						</select>
					</label>
					<label class="post-field-item"><?php esc_html_e( 'Item:', 'oscillator' ); ?>
						<?php
							oscillator_dropdown_posts( array(
								'post_type'            => 'post',
								'class'                => 'widefat posts_dropdown',
								'show_option_none'     => '&nbsp;',
								'select_even_if_empty' => true,
							), $ids_name );
						?>
					</label>
					<p class="ci-repeating-remove-action"><a href="#" class="button ci-repeating-remove-field"><i class="dashicons dashicons-dismiss"></i><?php esc_html_e( 'Remove me', 'oscillator' ); ?></a></p>
				</div>
			</div>
			<a href="#" class="ci-repeating-add-field button"><i class="dashicons dashicons-plus-alt"></i><?php esc_html_e( 'Add Item', 'oscillator' ); ?></a>
		</fieldset>

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
	}

	static function _ajax_get_posts() {
		$post_type_name = sanitize_key( $_POST['post_type_name'] );
		$name_field     = esc_attr( $_POST['name_field'] );

		$str = oscillator_dropdown_posts( array(
			'echo'                 => false,
			'post_type'            => $post_type_name,
			'class'                => 'widefat posts_dropdown',
			'show_option_none'     => '&nbsp;',
			'select_even_if_empty' => true,
		), $name_field );

		echo $str;
		die;
	}

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

register_widget( 'CI_Items_Widget' );

endif;