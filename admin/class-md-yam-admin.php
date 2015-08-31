<?php

/**
 * The admin-specific functionality of the project.
 *
 * @link       http://mustdigital.ru
 * @since      1.0.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/admin
 */

/**
 * The admin-specific functionality of the project.
 *
 * Defines the project name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/admin
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Admin {

	/**
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $project_name    The ID of this project.
	 */
	private $project_name;

	/**
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this project.
	 */
	private $version;

	/**
	 * @since    1.0.0
	 * @param      string    $project_name       The name of this project.
	 * @param      string    $version    The version of this project.
	 */
	public function __construct( $project_name, $version ) {

		$this->project_name = $project_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

//		wp_enqueue_style( $this->project_name, plugin_dir_url( __FILE__ ) . 'css/md-yam-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->project_name, plugin_dir_url( __FILE__ ) . 'css/md-yam-admin.css', array(), time(), 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

//		wp_enqueue_script( $this->project_name, plugin_dir_url( __FILE__ ) . 'js/md-yam-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->project_name, plugin_dir_url( __FILE__ ) . 'js/md-yam-admin.js', array( 'jquery' ), time(), true );

	}

}
