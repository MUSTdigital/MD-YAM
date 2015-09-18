<?php

/**
 * The admin-specific functionality of the project.
 *
 * @link       http://mustdigital.ru
 * @since      0.5.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 */

/**
 * The admin-specific functionality of the project.
 *
 * Defines the project name, version, and two examples hooks for how to
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
	 * @var      string  $project_name  The ID of this project.
	 * @var      string  $version       The current version of this project.
	 * @var      string  $url           The url to the project core folder.
	 */
	private $project_name,
            $version,
            $url;

	/**
	 * @since  0.5.0
	 * @param  string  $project_name  The ID of this project.
	 * @param  string  $version       The current version of this project.
	 * @param  string  $url           The url to the project core folder.
	 */
	public function __construct() {

        $this->project_name = MDYAM_PROJECT_NAME;
		$this->version = MDYAM_VERSION;
		$this->url = MDYAM_PROJECT_URL;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.5.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->project_name, $this->url . 'assets/css/md-yam-admin.css', array(), $this->version, 'all' );
		wp_register_style( $this->project_name . '-iconpicker', $this->url . 'assets/css/md-iconpicker.css', array(), $this->version, 'all' );
		wp_register_style( $this->project_name . '-filepicker', $this->url . 'assets/css/md-filepicker.css', array(), $this->version, 'all' );
		wp_register_style( $this->project_name . '-ace', $this->url . 'assets/css/md-codeeditor.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.5.0
	 */
	public function enqueue_scripts() {

        wp_enqueue_script( $this->project_name, $this->url . 'assets/js/md-yam-admin.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->project_name . '-iconpicker', $this->url . 'assets/js/md-iconpicker.js', array( 'jquery', $this->project_name ), $this->version, true );
		wp_register_script( $this->project_name . '-filepicker', $this->url . 'assets/js/md-filepicker.js', array( 'jquery', $this->project_name ), $this->version, true );
		wp_register_script( $this->project_name . '-ace', $this->url . 'assets/js/ace/ace.js', array(), $this->version, true );

	}

}
