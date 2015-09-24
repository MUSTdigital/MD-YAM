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
		require_once $this->path . 'fieldset/class-md-yam-templates.php';

		/**
		 * Fieldset generator.
		 */
		require_once $this->path . 'fieldset/class-md-yam-fieldset.php';

		/**
		 * Contains metabox actions.
		 */
		require_once $this->path . 'fieldset/class-md-yam-postmeta.php';

		/**
		 * Contains usermeta actions.
		 */
		require_once $this->path . 'fieldset/class-md-yam-usermeta.php';

		/**
		 * Contains options actions..
		 */
		require_once $this->path . 'fieldset/class-md-yam-site-options.php';

		$this->loader = new MD_YAM_Loader();

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
	 * Generate new fieldset.
	 *
	 * @access   private
	 * @since    0.6.3
	 */
	private function make_fieldset( $options, $fields ) {

        $fieldset = new MD_YAM_Fieldset( $options, $fields );

        $this->loader->add_action( '_md_yam_fieldset_list', $fieldset, 'add_fieldset_listitem' );

        if (!$fieldset->check_object_id()) {
            return;
        }

        switch ($fieldset->get_var('options')['type']) {

            case ('postmeta'):
                $postmeta = new MD_YAM_Postmeta( $fieldset );

                $this->loader->add_action( 'add_meta_boxes', $postmeta, 'add_meta_box' );
                $this->loader->add_action( 'save_post', $postmeta, 'save_meta' );
                $this->loader->add_action( 'admin_enqueue_scripts', $postmeta, 'enqueue_postmeta_scripts' );
                break;

            case ('usermeta'):
                $usermeta = new MD_YAM_Usermeta( $fieldset );

                $this->loader->add_action( 'show_user_profile', $usermeta, 'add_meta_fields' );
                $this->loader->add_action( 'edit_user_profile', $usermeta, 'add_meta_fields' );
                $this->loader->add_action( 'personal_options_update', $usermeta, 'save_meta' );
                $this->loader->add_action( 'edit_user_profile_update', $usermeta, 'save_meta' );
                $this->loader->add_action( 'admin_enqueue_scripts', $usermeta, 'enqueue_usermeta_scripts' );
                break;

            case ('dashboard'):
                $site_options = new MD_YAM_Site_Options( $fieldset );

                $this->loader->add_action( 'wp_dashboard_setup', $site_options, 'add_dashboard_widget' );
                $this->loader->add_action( 'wp_ajax_md_yam_save_options', $site_options, 'ajax_save_options' );
                $this->loader->add_action( 'admin_enqueue_scripts', $site_options, 'enqueue_dashboard_scripts' );
                break;

            case ('menu_page'):
            case ('submenu_page'):
                $site_options = new MD_YAM_Site_Options( $fieldset );

                $this->loader->add_action( 'admin_menu', $site_options, 'add_options_page' );
                $this->loader->add_action( 'wp_ajax_md_yam_save_options', $site_options, 'ajax_save_options' );
                $this->loader->add_action( 'admin_enqueue_scripts', $site_options, 'enqueue_menupage_scripts' );
                break;

        }

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
	 * @access  public
	 * @since   0.6.0
	 * @return  MD_YAM_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Reference for a new Fieldset
	 *
	 * @access  public
	 * @since   0.6.3
	 */
	public function new_fieldset( $options, $fields ) {
		$this->make_fieldset( $options, $fields );
	}

}
