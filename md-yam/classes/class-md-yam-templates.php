<?php

/**
 * Actions and filters refered to templates
 *
 * @link        http://mustdigital.ru
 * @since       0.5.0
 *
 * @package     MD_YAM
 * @subpackage  MD_YAM/classes
 */

/**
 * Actions and filters refered to templates.
 * @package     MD_YAM
 * @subpackage  MD_YAM/classes
 * @author      Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Templates {

	/**
	 * @since   0.5.0
	 * @access  private
	 * @var     string  $plugin_name  The ID of this plugin.
	 * @var     string  $version      The current version of this plugin.
	 * @var     string  $path         Path to default templates folder.
	 * @var     string  $theme        Path to current theme.
	 */
	private $plugin_name,
            $version,
            $path,
            $theme;

	/**
	 * @since  0.5.0
	 * @param  string  $plugin_name  The ID of this plugin.
	 * @param  string  $version      The current version of this plugin.
	 * @param  string  $path         Path to default templates folder.
	 */
	public function __construct() {

        $this->plugin_name = MDYAM_PROJECT_NAME;
		$this->version = MDYAM_VERSION;
		$this->path = MDYAM_PROJECT_DIR;
        $this->theme = get_stylesheet_directory();

	}

    /**
     * Generates HTML with appropriate template.
     * Used in 'md_yam_generate_field_template' filter.
     *
     * @param  string  $fields_html  Generated fields HTML.
     * @param  array   $options      Array of options.
     * @return string                Generated HTML.
     */
    public function generate_fieldset_template( $fields_html, $options ) {

        switch ( $options['type'] ) {

            case ( 'metabox' ):
                $template = 'types/metabox.php';
                break;

            case ( 'dashboard' ):
                $template = 'types/dashboard.php';
                break;

            case ( 'menu_page' ):
            case ( 'submenu_page' ):
            default:
                $template = 'types/options.php';
                break;
        }

        ob_start();

        // Try custom type template
        if ( file_exists( $this->theme . '/md-yam/' . $template ) ) {
            include $this->theme . '/md-yam/' . $template;

        // Else try default type template
        } elseif ( file_exists( $this->path . 'templates/' . $template ) ) {
            include $this->path . 'templates/' . $template;

        // Else echo error.
        } else {
            echo sprintf( __( 'No template: %s', 'md-yam' ), $template );
        }
        return ob_get_clean();

    }

    /**
     * Generate HTML for particular field with appropriate template.
     * Used in 'md_yam_generate_fieldset_template' filter.
     *
     * @param  array   $meta  Field meta.
     * @return string         Generated HTML.
     */
    public function generate_field_template( $meta ) {

        switch ( $meta['type'] ) {

            case 'block-end':
            case 'block-start':
            case 'tab-end':
            case 'tab-start':
            case 'tabs-nav':
            case 'heading':
                $template = 'helpers/' . $meta['type'] . '.php';
                break;

            default:
                $template = 'fields/' . $meta['type'] . '.php';

        }

        ob_start();

        // Try custom field template
        if ( file_exists( $this->theme . '/md-yam/' . $template ) ) {
            include $this->theme . '/md-yam/' . $template;

        // Else try default field template
        } elseif ( file_exists( $this->path . 'templates/' . $template ) ) {
            include $this->path . 'templates/' . $template;

        // Else try custom text field template
        } elseif ( file_exists( $this->theme . '/md-yam/fields/text.php' ) ) {
            include $this->theme . '/md-yam/fields/text.php';

        // Else try default text field template
        } elseif ( file_exists( $this->path . 'templates/fields/text.php' ) ) {
            include $this->path . 'templates/fields/text.php';

        // Almost impossible situation, but whatever.
        } else {
            echo sprintf( __( 'No template: %s', 'md-yam' ), $template );
        }

        return ob_get_clean();

    }


}
