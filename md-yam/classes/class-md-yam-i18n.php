<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
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
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.5.0
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_i18n {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $domain    The domain identifier for this plugin.
	 * @var      string    $path    The path to the plugin core.
	 */
	private $domain,
	        $plugin_name,
            $path;

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    0.5.0
	 * @param    string    $domain    The domain identifier for this plugin.
	 * @param    string    $path    The path to the plugin core.
	 */
	public function __construct() {

		$this->domain      = MDYAM_PROJECT_NAME;
		$this->plugin_name = MDYAM_PROJECT_NAME;
		$this->path        = MDYAM_PROJECT_REL_DIR;

	}

    /**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.5.0
	 */
	public function load_plugin_textdomain() {

        load_plugin_textdomain(
			$this->domain,
			false,
			$this->path . '/languages'
		);

	}

    /**
	 * @since    0.6.0
	 */
	public function localize_scripts() {

        wp_localize_script(
            $this->plugin_name . '-iconpicker',
            'mdLocaleIconpicker',
            [
                'search' => _x('Search', 'Iconpicker script', 'md-yam')
            ]
        );

	}

}
