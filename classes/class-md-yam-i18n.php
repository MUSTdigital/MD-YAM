<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this project
 * so that it is ready for translation.
 *
 * @link       http://mustdigital.ru
 * @since      0.5.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this project
 * so that it is ready for translation.
 *
 * @since      0.5.0
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_i18n {

	/**
	 * The domain specified for this project.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $domain    The domain identifier for this project.
	 * @var      string    $path    The path to the project core.
	 */
	private $domain,
            $path;

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    0.5.0
	 * @param    string    $domain    The domain identifier for this project.
	 * @param    string    $path    The path to the project core.
	 */
	public function __construct() {

		$this->domain = MDYAM_PROJECT_NAME;
		$this->path = MDYAM_PROJECT_DIR;

	}

    /**
	 * Load the project text domain for translation.
	 *
	 * @since    0.5.0
	 */
	public function load_project_textdomain() {

		load_plugin_textdomain(
			$this->domain,
			false,
			$this->path . 'languages/'
		);

	}

}
