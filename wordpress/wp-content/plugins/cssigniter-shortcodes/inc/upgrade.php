<?php
	//
	// Handle upgrades
	//
	$ci_shortcodes_installed_version = get_option( CI_SHORTCODES_PLUGIN_INSTALLED );
	if ( empty( $ci_shortcodes_installed_version ) ) {
		$defaults = ci_shortcodes_get_default_settings();
		update_option( CI_SHORTCODES_PLUGIN_OPTIONS, $defaults );
		update_option( CI_SHORTCODES_PLUGIN_INSTALLED, '2.3' );
	} elseif ( CI_SHORTCODES_VERSION !== $ci_shortcodes_installed_version ) {
		_ci_shortcodes_do_upgrade( $ci_shortcodes_installed_version );
	}

	function _ci_shortcodes_do_upgrade( $version ) {
		$version = _ci_shortcodes_upgrade_to_1_0( $version );
		$version = _ci_shortcodes_upgrade_to_1_1( $version );
		$version = _ci_shortcodes_upgrade_to_1_2( $version );
		$version = _ci_shortcodes_upgrade_to_2_0( $version );
		$version = _ci_shortcodes_upgrade_to_2_1( $version );
		$version = _ci_shortcodes_upgrade_to_2_2( $version );
		$version = _ci_shortcodes_upgrade_to_2_3( $version );
		update_option( CI_SHORTCODES_PLUGIN_INSTALLED, $version );
	}

	function _ci_shortcodes_upgrade_to_2_3( $version ) {
		if ( '2.2' === $version ) {
			// No DB changes in this update
			return '2.3';
		} else {
			return $version;
		}
	}
	function _ci_shortcodes_upgrade_to_2_2( $version ) {
		if ( '2.1' === $version ) {
			// No DB changes in this update
			return '2.2';
		} else {
			return $version;
		}
	}
	function _ci_shortcodes_upgrade_to_2_1( $version ) {
		if ( '2.0' === $version ) {
			// No DB changes in this update
			return '2.1';
		} else {
			return $version;
		}
	}
	function _ci_shortcodes_upgrade_to_2_0( $version ) {
		if ( '1.2' === $version ) {
			$opts = get_option( CI_SHORTCODES_PLUGIN_OPTIONS );
			if ( isset( $opts['theme'] ) ) {
				unset( $opts['theme'] );
			}
			if ( isset( $opts['only_single_css'] ) ) {
				unset( $opts['only_single_css'] );
			}
			$opts['headings_default_level'] = '2';
			$opts['google_maps_api_enable'] = 'enabled';
			$opts['google_maps_api_key']    = '';
			update_option( CI_SHORTCODES_PLUGIN_OPTIONS, $opts );
			return '2.0';
		} else {
			return $version;
		}
	}

	function _ci_shortcodes_upgrade_to_1_2( $version ) {
		if ( '1.1' === $version ) {
			// No DB changes in this update
			return '1.2';
		} else {
			return $version;
		}
	}

	function _ci_shortcodes_upgrade_to_1_1( $version ) {
		if ( '0.9' === $version || '1.0' === $version ) {
			// No DB changes in this update
			return '1.1';
		} else {
			return $version;
		}
	}

	function _ci_shortcodes_upgrade_to_1_0( $version ) {
		if ( empty( $version ) || false === $version ) {
			// No DB changes in this update
			return '1.0';
		} else {
			return $version;
		}
	}
