<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this project
 * so that it is ready for translation.
 *
 * @link       http://mustdigital.ru
 * @since      1.0.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this project
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    MD_YAM
 * @subpackage MD_YAM/includes
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_i18n {

	/**
	 * The domain specified for this project.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $domain    The domain identifier for this project.
	 */
	private $domain;

	/**
	 * Load the project text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_project_textdomain() {

		load_project_textdomain(
			$this->domain,
			false,
			dirname( dirname( project_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    1.0.0
	 * @param    string    $domain    The domain that represents the locale of this project.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}
