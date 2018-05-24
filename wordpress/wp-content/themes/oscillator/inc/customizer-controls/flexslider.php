<?php
/**
 * Customize FlexSlider Control class.
 *
 * @see WP_Customize_Control
 */
class Oscillator_Customize_Flexslider_Control extends WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'flexslider';

	/**
	 * Taxonomy for category dropdown.
	 *
	 * @access public
	 * @var string
	 */
	protected $options = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$this->options = $options;

		if ( ! isset( $args['settings'] ) ) {
			$manager->add_setting( $id . '_show', array(
				'default'           => 1,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );
			$manager->add_setting( $id . '_term', array(
				'default'           => '',
				'sanitize_callback' => 'absint',
			) );
			$manager->add_setting( $id . '_slideshow', array(
				'default'           => 1,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );
			$manager->add_setting( $id . '_animation', array(
				'default'           => 'fade',
				'sanitize_callback' => array( $this, 'sanitize_animation' ),
			) );
			$manager->add_setting( $id . '_direction', array(
				'default'           => 'horizontal',
				'sanitize_callback' => array( $this, 'sanitize_direction' ),
			) );
			$manager->add_setting( $id . '_slideshowSpeed', array(
				'default'           => 3000,
				'sanitize_callback' => 'absint',
			) );
			$manager->add_setting( $id . '_animationSpeed', array(
				'default'           => 600,
				'sanitize_callback' => 'absint',
			) );
			$this->settings = array(
				'show'           => $id . '_show',
				'term'           => $id . '_term',
				'slideshow'      => $id . '_slideshow',
				'animation'      => $id . '_animation',
				'direction'      => $id . '_direction',
				'slideshowSpeed' => $id . '_slideshowSpeed',
				'animationSpeed' => $id . '_animationSpeed',
			);
		}
		parent::__construct( $manager, $id, $args );
	}

	protected function render_content() {
		if ( ! empty( $this->label ) ) :
			?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
		endif;

		if ( ! empty( $this->description ) ) :
			?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php
		endif;

		?>
		<ul>
			<li>
				<label>
					<input type="checkbox" value="1" <?php $this->link( 'show' ); ?> <?php checked( $this->value( 'show' ), 1 ); ?> />
					<?php _e( 'Show slider.', 'oscillator' ); ?>
				</label>
			</li>

			<li>
				<label>
					<input type="checkbox" value="1" <?php $this->link( 'slideshow' ); ?> <?php checked( $this->value( 'slideshow' ), 1 ); ?> />
					<?php _e( 'Auto slide.', 'oscillator' ); ?>
				</label>
			</li>

			<li>
				<?php
					$options = wp_parse_args( $this->options, array(
						'taxonomy'          => 'category',
						'show_option_none'  => ' ',
						'selected'          => $this->value( 'term' ),
						'show_option_all'   => '',
						'orderby'           => 'id',
						'order'             => 'ASC',
						'show_count'        => 1,
						'hide_empty'        => 1,
						'child_of'          => 0,
						'exclude'           => '',
						'hierarchical'      => 1,
						'depth'             => 0,
						'tab_index'         => 0,
						'hide_if_empty'     => false,
						'option_none_value' => 0,
						'value_field'       => 'term_id',
					) );
					$options['echo'] = false;

					$dropdown = wp_dropdown_categories( $options );
					$dropdown = str_replace( '<select', '<select ' . $this->get_link( 'term' ), $dropdown );
					$dropdown = str_replace( "name='cat' id='cat' class='postform'", '', $dropdown );
					?><label><span class="customize-control-title"><?php esc_html_e( 'Source category', 'oscillator' ); ?></span></label><?php
					echo $dropdown;
				?>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php _e( 'Slide change effect:', 'oscillator' ); ?></span>
					<select <?php $this->link( 'animation' ); ?>>
						<option value="slide" <?php selected( $this->value( 'animation' ), 'slide' ); ?>><?php echo esc_html_x( 'Slide', 'slider effect', 'oscillator' ); ?></option>
						<option value="fade" <?php selected( $this->value( 'animation' ), 'fade' ); ?>><?php echo esc_html_x( 'Fade', 'slider effect', 'oscillator' ); ?></option>
					</select>
				</label>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php _e( 'Slide change direction:', 'oscillator' ); ?></span>
					<span class="description customize-control-description"><?php echo strip_tags( __( 'Only applicable when slide effect is <strong>Slide</strong>.', 'oscillator' ), '<strong>' ); ?></span>
					<select <?php $this->link( 'direction' ); ?>>
						<option value="horizontal" <?php selected( $this->value( 'direction' ), 'horizontal' ); ?>><?php echo esc_html_x( 'Horizontal', 'slider effect direction', 'oscillator' ); ?></option>
						<option value="vertical" <?php selected( $this->value( 'direction' ), 'vertical' ); ?>><?php echo esc_html_x( 'Vertical', 'slider effect direction', 'oscillator' ); ?></option>
					</select>
				</label>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php _e( 'Pause between slides (in milliseconds):', 'oscillator' ); ?></span>
					<input type="number" min="100" step="100" value="<?php echo esc_attr( $this->value( 'slideshowSpeed' ) ); ?>" <?php $this->link( 'slideshowSpeed' ); ?> />
				</label>
			</li>

			<li>
				<label>
					<span class="customize-control-title"><?php _e( 'Duration of animation (in milliseconds):', 'oscillator' ); ?></span>
					<input type="number" min="100" step="100" value="<?php echo esc_attr( $this->value( 'animationSpeed' ) ); ?>" <?php $this->link( 'animationSpeed' ); ?> />
				</label>
			</li>
		</ul>
		<?php

	}

	public static function sanitize_animation( $input ) {
		return in_array( $input, array( 'fade', 'slide' ) ) ? $input : 'fade';
	}

	public static function sanitize_direction( $input ) {
		return in_array( $input, array( 'horizontal', 'vertical' ) ) ? $input : 'horizontal';
	}

	public static function sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		}

		return '';
	}

	public static function sanitize_positive_or_minus_one( $input ) {
		if ( intval( $input ) > 0 ) {
			return intval( $input );
		}

		return - 1;
	}

}
