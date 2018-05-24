<?php
	//
	// Tooltips
	//
	function ci_shortcodes_get_documentation_tooltip() {
		return array(
			'tooltip' => array(
				'title'       => esc_html__( 'Tooltip', 'cssigniter-shortcodes' ),
				'description' => esc_html__( 'Styled tooltip.', 'cssigniter-shortcodes' ),
				'aliases'     => array(),
				'attributes'  => array(
					'tip'      => array(
						'title'   => esc_html__( 'Tip text', 'cssigniter-shortcodes' ),
						'values'  => '',
						'default' => '',
						'info'    => esc_html__( 'This is the text that gets displayed on hover.', 'cssigniter-shortcodes' ),
					),
					'position' => array(
						'title'   => esc_html__( 'Tooltip Position', 'cssigniter-shortcodes' ),
						'values'  => 'top, bottom, left, right',
						'default' => '',
						'info'    => '',
					),
					'alwayson' => array(
						'title'   => esc_html__( 'Always On', 'cssigniter-shortcodes' ),
						'values'  => wp_kses( __( 'Simply type <em>alwayson</em> without a value.', 'cssigniter-shortcodes' ), array( 'em' => array() ) ),
						'default' => '',
						'info'    => '',
					),
					'light'    => array(
						'title'   => esc_html__( 'Light Scheme', 'cssigniter-shortcodes' ),
						'values'  => wp_kses( __( 'Simply type <em>light</em> without a value.', 'cssigniter-shortcodes' ), array( 'em' => array() ) ),
						'default' => '',
						'info'    => '',
					),
				),
				'examples'    => array(
					'Do you know what a [tooltip tip="Central Processing Unit" position="top" alwayson light]CPU[/tooltip] is?',
				),
			),
		);
	}

	function _ci_shortcodes_tooltips_back_compat( $atts ) {
		if ( ! empty( $atts['contents'] ) && empty( $atts['tip'] ) ) {
			$atts['tip'] = $atts['contents'];
		}
		if ( ! empty( $atts['color'] ) && 'grey' === $atts['color'] ) {
			$atts['color'] = 'light';
		}

		return $atts;
	}

	function ci_shortcodes_tooltips( $atts, $content = null, $tag ) {
		$atts = _ci_shortcodes_tooltips_back_compat( $atts );

		$alwayson = array_search( 'alwayson', (array) $atts, true );
		if ( false !== $alwayson && is_numeric( $alwayson ) ) {
			$atts['always'] = 'on';
		}

		$light = array_search( 'light', (array) $atts, true );
		if ( false !== $light && is_numeric( $light ) ) {
			$atts['color'] = 'light';
		}

		$atts = shortcode_atts( array(
			'tip'      => '',
			'position' => '',
			'always'   => '', // empty or 'on'
			'color'    => '', // empty = dark, or 'light'
		), $atts, $tag );

		$tip      = $atts['tip'];
		$position = $atts['position'];
		$always   = $atts['always'];
		$color    = $atts['color'];

		$attr_classes = array( 'hint' );
		$attr_style   = array();

		$tip = sanitize_text_field( $tip );

		if ( ! empty( $position ) && in_array( $position, array( 'top', 'bottom', 'left', 'right' ), true ) ) {
			$attr_classes[] = 'hint--' . $position;
		}
		if ( 'on' === $always ) {
			$attr_classes[] = 'hint--always';
		}
		if ( 'light' === $color ) {
			$attr_classes[] = 'hint--light';
		}

		$markup = apply_filters( 'ci_shortcodes_tooltip_markup', '<span class="%1$s" style="%2$s" data-hint="%3$s">%4$s</span>' );
		$output = sprintf( $markup,
			esc_attr( implode( ' ', $attr_classes ) ),
			esc_attr( implode( ' ', $attr_style ) ),
			esc_attr( $tip ),
			do_shortcode( $content )
		);

		return $output;
	}
