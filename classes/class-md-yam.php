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
	 * @var     string         $project_name  The project name.
	 * @var     string         $version       The current version of the MD YAM.
	 * @var     MD_YAM_Loader  $loader        Maintains and registers all hooks for the project.
	 * @var     string         $path          The path to the project core.
	 * @var     string         $url           The url to the project core folder.
	 */
	private $project_name,
            $version,
            $loader,
            $path,
            $url;

	/**
	 * Define the core functionality of the MD YAM.
	 *
	 * Set the prefix and MD YAM version that can be used throughout the project.
	 * Load the dependencies, define the locale, and set the hooks for the admin area of the site.
	 *
	 * @access   private
	 * @since    0.5.0
	 */
    public function __construct( $path, $url ) {

		$this->project_name = 'md-yam';
		$this->version = '0.5.0';
		$this->path = $path;
		$this->url = $url;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_template_hooks();

    }


	/**
	 * Load the required dependencies for the project.
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

		$this->loader = new MD_YAM_Loader();

	}

	/**
	 * Define the locale for this project for internationalization.
	 *
	 * Uses the MD_YAM_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function set_locale() {

		$project_i18n = new MD_YAM_i18n( $this->project_name, $this->path );

		$this->loader->add_action( 'projects_loaded', $project_i18n, 'load_project_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the project.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$project_admin = new MD_YAM_Admin( $this->project_name, $this->version, $this->url );

		$this->loader->add_action( 'admin_enqueue_scripts', $project_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $project_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$project_templates = new MD_YAM_Templates( $this->project_name, $this->version, $this->path );

        $this->loader->add_filter( 'md_yam_generate_field_template', $project_templates, 'generate_field_template' , 50);
        $this->loader->add_filter( 'md_yam_generate_fieldset_template', $project_templates, 'generate_fieldset_template' , 50, 2);

	}

	/**
	 * Run the loader.
	 *
	 * @since    0.5.0
	 */
	public function run() {

		$this->loader->run();
	}

}
