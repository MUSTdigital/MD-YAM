<?php

/**
 * @link              http://mustdigital.ru
 * @since             0.5.0
 * @package           MD_YAM
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core project class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-md-yam.php';
require plugin_dir_path( __FILE__ ) . 'admin/class-md-yam-fieldset.php';

/**
 * Begins execution of the project.
 *
 * Since everything within the project is registered via hooks,
 * then kicking off the project from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.5.0
 */
function run_MD_YAM() {

	$project = new MD_YAM();
	$project->run();

}
run_MD_YAM();
