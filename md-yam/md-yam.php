<?php

/**
 * @link              http://mustdigital.ru/
 * @since             0.5.0
 * @package           MD_YAM
 *
 * @wordpress-plugin
 * Plugin Name:       MD Yet Another Metafield
 * Plugin URI:        http://mustdigital.ru/projects/md-yam
 * Description:       This plugin can work with post meta fields (metaboxes), user meta and site options (options pages and admin dashboard widgets).
 * Version:           0.7.2
 * Author:            Dmitry Korolev
 * Author URI:        http://mustdigital.ru/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       md-yam
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'MDYAM_VERSION', '0.7.2' );
define( 'MDYAM_PROJECT_NAME', 'md-yam' );
define( 'MDYAM_PROJECT_URL', plugin_dir_url( __FILE__ ) );
define( 'MDYAM_PROJECT_DIR', plugin_dir_path( __FILE__ ) );
define( 'MDYAM_PROJECT_REL_DIR', dirname( plugin_basename( __FILE__ ) ) );

require MDYAM_PROJECT_DIR . 'classes/class-md-yam-autoloader.php';
MD_YAM_Autoloader::register();

require MDYAM_PROJECT_DIR . 'functions.php';

$md_yam_all_fieldsets = [];

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.5.0
 */
function run_MD_YAM() {

    global $md_yam_all_fieldsets;
    do_action( 'md_yam_init' );

    $md_yam_object = new MD_YAM();
    foreach($md_yam_all_fieldsets as $fieldset){
        $md_yam_object->new_fieldset( $fieldset['options'], $fieldset['fields'] );
    }

    $md_yam_object->run();

}
add_action( 'after_setup_theme', 'run_MD_YAM' );
