<?php
/**
 * Customize Dropdown Posts Control class.
 *
 * @see WP_Customize_Control
 */
class Oscillator_Customize_Dropdown_Posts_Control extends WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'dropdown-posts';

	protected $options = false;
	protected $posts = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$this->options = wp_parse_args( $options, array(
			'post_type'      => 'post',
			'posts_per_page' => - 1,
		) );

		$this->posts = get_posts( $this->options );

		parent::__construct( $manager, $id, $args );
	}

	protected function render_content() {
		?><label><?php

		if ( ! empty( $this->label ) ) :
			?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
		endif;

		if ( ! empty( $this->description ) ) :
			?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php
		endif;

		?>
		<select <?php $this->link(); ?>>
			<option value="" <?php checked( $this->value(), '' ); ?>>&nbsp;</option>
			<?php if( ! empty( $this->posts ) ): ?>
				<?php foreach( $this->posts as $post ): ?>
					<option value="<?php echo esc_attr( $post->ID ); ?>" <?php checked( $this->value(), $post->ID ); ?>><?php echo esc_html( get_the_title( $post->ID ) ); ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		<?php
		?></label><?php
	}

}
