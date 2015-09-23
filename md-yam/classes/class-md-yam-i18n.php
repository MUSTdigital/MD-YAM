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

        $var = load_plugin_textdomain(
			$this->domain,
			false,
			$this->path . '/languages'
		);

//        if (!$var) {
//            mdd(MDYAM_PROJECT_REL_DIR);
//        }

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

    /**
     * Localize strings in some special occasions.
     *
     * @since    0.6.2
     * @access   public
     * @param  sting  $string String to localize
     * @return string         Localized string
     */
    public function all_in_one_localization($string) {
        $strings = [
            // Fieldset types
            'postmeta'       => __('Post metabox', 'md-yam'),
            'dashboard'      => __('Dashboard widget', 'md-yam'),
            'menu_page'      => __('Admin menu page', 'md-yam'),
            'submenu_page'   => __('Admin sub menu page', 'md-yam'),

            // Field types
            'checkbox'       => __('Checkbox', 'md-yam'),
            'code-editor'    => __('Code editor', 'md-yam'),
            'icon-picker'    => __('Icon picker', 'md-yam'),
            'posts'          => __('Posts dropdown', 'md-yam'),
            'radio'          => __('Radio', 'md-yam'),
            'select'         => __('Select', 'md-yam'),
            'textarea'       => __('Textarea', 'md-yam'),
            'tinymce'        => __('TinyMCE', 'md-yam'),
            'wp-color'       => __('WP color picker', 'md-yam'),
            'wp-file'        => __('WP file picker', 'md-yam'),
            'wp-image'       => __('WP image picker', 'md-yam'),
            'text'           => __('Text', 'md-yam'),

            // HTML5 Field types
            'time'           => __('Time', 'md-yam'),
            'date'           => __('Date', 'md-yam'),
            'datetime'       => __('Date and time', 'md-yam'),
            'datetime-local' => __('Local date and time', 'md-yam'),
            'month'          => __('Month', 'md-yam'),
            'week'           => __('Week', 'md-yam'),
            'number'         => __('Number', 'md-yam'),
            'range'          => __('Range', 'md-yam'),
            'email'          => __('Email', 'md-yam'),
            'url'            => __('URL', 'md-yam'),
            'tel'            => __('Phone number', 'md-yam'),
            'color'          => __('Color picker', 'md-yam')
        ];

        return $strings[$string];
    }
}
