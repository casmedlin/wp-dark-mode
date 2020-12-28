<?php

defined( 'ABSPATH' ) || exit();

class WP_Dark_Mode_Update {


	/**
	 * The upgrades
	 *
	 * @var array
	 */
	private static $upgrades = array(
		'1.0.9' => 'includes/updates/update-1.0.9.php',
	);

	public function installed_version() {

		return get_option( 'wp_dark_mode_version' );
	}

	/**
	 * Check if the plugin needs any update
	 *
	 * @return boolean
	 */
	public function needs_update() {

		// may be it's the first install
		if (! $this->installed_version() ) {
			return false;
		}

		//if previous version is lower
		if ( version_compare( $this->installed_version(), WP_DARK_MODE_VERSION, '<' ) ) {
			return true;
		}


		return false;
	}

	/**
	 * Perform all the necessary upgrade routines
	 *
	 * @return void
	 */
	function perform_updates() {
		foreach ( self::$upgrades as $version => $file ) {
			if ( version_compare( $this->installed_version(), $version, '<' ) ) {
				include WP_DARK_MODE_INCLUDES.'/updates/'.$file;
				update_option( 'wp_dark_mode_version', $version );
			}
		}

		delete_option( 'wp_dark_mode_version' );
		update_option( 'wp_dark_mode_version', wp_dark_mode()->version );
	}



}
