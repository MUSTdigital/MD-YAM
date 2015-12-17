<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://mustdigital.ru
 * @since      0.5.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Admin {

    /**
     * @since    0.5.0
     * @access   private
     * @var      string  $plugin_name  The ID of this plugin.
     * @var      string  $version       The current version of this plugin.
     * @var      string  $url           The url to the plugin core folder.
     */
    private $plugin_name,
            $version,
            $url;

    /**
     * @since  0.5.0
     * @param  string  $plugin_name  The ID of this plugin.
     * @param  string  $version       The current version of this plugin.
     * @param  string  $url           The url to the plugin core folder.
     */
    public function __construct() {

        $this->plugin_name = MDYAM_PROJECT_NAME;
        $this->version = MDYAM_VERSION;
        $this->path = MDYAM_PROJECT_DIR;
        $this->url = MDYAM_PROJECT_URL;

    }

    /**
     * Enqueue the stylesheets for the admin area.
     *
     * @since    0.5.0
     */
    public function enqueue_styles() {

        wp_enqueue_style( $this->plugin_name, $this->url . 'assets/css/md-yam-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    0.6.0
     */
    public function register_styles() {

        wp_register_style( $this->plugin_name . '-iconpicker', $this->url . 'assets/css/md-iconpicker.css', array(), $this->version, 'all' );
        wp_register_style( $this->plugin_name . '-filepicker', $this->url . 'assets/css/md-filepicker.css', array(), $this->version, 'all' );
        wp_register_style( $this->plugin_name . '-ace', $this->url . 'assets/css/md-codeeditor.css', array(), $this->version, 'all' );

    }

    /**
     * Enqueue the JavaScript for the admin area.
     *
     * @since    0.5.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, $this->url . 'assets/js/md-yam-admin.js', array( 'jquery' ), $this->version, true );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    0.6.0
     */
    public function register_scripts() {

        wp_register_script( $this->plugin_name . '-iconpicker', $this->url . 'assets/js/md-iconpicker.js', array( 'jquery', $this->plugin_name ), $this->version, true );
        wp_register_script( $this->plugin_name . '-filepicker', $this->url . 'assets/js/md-filepicker.js', array( 'jquery', $this->plugin_name ), $this->version, true );
        wp_register_script( $this->plugin_name . '-ace', $this->url . 'assets/js/ace/ace.js', array(), $this->version, true );

    }

    /**
     * Admin page for MD YAM
     *
     * @since 0.6.2
     */
    public function add_admin_page() {
        add_management_page(
            __('MD Yet Another Metafield', 'md-yam'),
            __('MD YAM', 'md-yam'),
            'manage_options',
            'md-yam',
            [ $this, 'admin_page_template' ]
        );
    }

    /**
     * Render admin menu page.
     *
     * @since 0.6.2
     */
    public function admin_page_template() {
        require_once $this->path . 'assets/partitials/admin-page.php';
    }

}
