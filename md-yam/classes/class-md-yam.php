<?php

/**
 *
 * @link       http://mustdigital.ru
 * @since      0.5.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 */

/**
 *
 * This is used to define internationalization and admin-specific hooks.
 *
 * @since      0.5.0
 * @package    MD_YAM
 * @subpackage MD_YAM/includes
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM {

	/**
	 * @since   0.5.0
	 * @access  private
	 * @var     string         $plugin_name  The plugin name.
	 * @var     string         $version       The current version of the MD YAM.
	 * @var     MD_YAM_Loader  $loader        Maintains and registers all hooks for the plugin.
	 * @var     string         $path          The path to the plugin core.
	 * @var     string         $url           The url to the plugin core folder.
	 */
	private $plugin_name,
            $version,
            $loader,
            $path,
            $url;

	/**
	 * @since   0.5.0
	 * @access  private
	 * @var     string   $functions  Helper functions object.
	 */
    private $functions;

	/**
	 * Define the core functionality of the MD YAM.
	 *
	 * Set the prefix and MD YAM version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area of the site.
	 *
	 * @access   private
	 * @since    0.5.0
	 */
    public function __construct() {

		$this->plugin_name = MDYAM_PROJECT_NAME;
		$this->version = MDYAM_VERSION;
		$this->path = MDYAM_PROJECT_DIR;
		$this->url = MDYAM_PROJECT_URL;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_template_hooks();

    }


	/**
	 * Load the required dependencies for the plugin.
	 *
	 * Include the following files that make up the MD YAM:
	 *
	 * - MD_YAM_Loader. Orchestrates the hooks.
	 * - MD_YAM_i18n. Defines internationalization functionality.
	 * - MD_YAM_Admin. Defines all hooks for the admin area.
	 * - MD_YAM_Templates. Defines all hooks related to templates.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of MD YAM.
		 */
		require_once $this->path . 'classes/class-md-yam-loader.php';

		/**
		 * The class responsible for defining internationalization functionality of MD YAM.
		 */
		require_once $this->path . 'classes/class-md-yam-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once $this->path . 'classes/class-md-yam-admin.php';

		/**
		 * Actions and filters refered to templates.
		 */
		require_once $this->path . 'classes/class-md-yam-templates.php';

		/**
		 * Contains helper functions.
		 */
		require_once $this->path . 'classes/class-md-yam-functions.php';

		/**
		 * Contains helper functions.
		 */
		require_once $this->path . 'classes/class-md-yam-fieldset.php';

		$this->loader = new MD_YAM_Loader();
		$this->functions = new MD_YAM_Functions($this->loader);

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the MD_YAM_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new MD_YAM_i18n();
		$this->loader->add_action( 'init', $plugin_i18n, 'load_plugin_textdomain' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_i18n, 'localize_scripts' );
		$this->loader->add_filter( '_md_yam_loc', $plugin_i18n, 'all_in_one_localization' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new MD_YAM_Admin();

		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_styles' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_page' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_templates = new MD_YAM_Templates();

        $this->loader->add_filter( 'md_yam_generate_field_template', $plugin_templates, 'generate_field_template' , 50);
        $this->loader->add_filter( 'md_yam_generate_fieldset_template', $plugin_templates, 'generate_fieldset_template' , 50, 2);

	}

	/**
	 * Run the loader.
	 *
	 * @since    0.5.0
	 */
	public function run() {

		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.6.0
	 * @return    MD_YAM_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.6.0
	 * @return    MD_YAM_Functions    Contains helper functions.
	 */
	public function get_functions() {
		return $this->functions;
	}

}
