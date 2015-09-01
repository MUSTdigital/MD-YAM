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
	 * @var     string  $project_name  The ID of this project.
	 * @var     string  $version       The current version of this project.
	 * @var     string  $path          Path to default templates folder.
	 * @var     string  $theme         Path to current theme.
	 */
	private $project_name,
            $version,
            $path,
            $theme;

	/**
	 * @since  0.5.0
	 * @param  string  $project_name  The ID of this project.
	 * @param  string  $version       The current version of this project.
	 * @param  string  $path          Path to default templates folder.
	 */
	public function __construct( $project_name, $version, $path ) {

		$this->project_name = $project_name;
		$this->version = $version;
		$this->path = $path;
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
        if ( file_exists( $this->theme . '/md-yam/' . $template ) ) {
            include $this->theme . '/md-yam/' . $template;
        } elseif ( file_exists( $this->path . 'templates/' . $template ) ) {
            include $this->path . 'templates/' . $template;
        } else {
            echo 'No template: ' . $template;
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

        $template = 'fields/' . $meta['type'] . '.php';

        ob_start();
        if ( file_exists( $this->theme . '/md-yam/' . $template ) ) {
            include $this->theme . '/md-yam/' . $template;
        } elseif ( file_exists( $this->path . 'templates/' . $template ) ) {
            include $this->path . 'templates/' . $template;
        } else {
            echo 'No template: ' . $template;
        }
        return ob_get_clean();

    }


}
