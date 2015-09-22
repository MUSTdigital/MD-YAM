<?php

/**
 * Contains helper functions.
 *
 * @link       http://mustdigital.ru
 * @since      0.6.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 */

/**
 * Contains helper functions.
 *
 * @since      0.6.0
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Functions {

	/**
	 * @since   0.6.0
	 * @access  private
	 * @var     string         $plugin_name  The plugin name.
	 * @var     string         $version       The current version of the MD YAM.
	 * @var     MD_YAM_Loader  $loader        Maintains and registers all hooks for the plugin.
	 * @var     string         $path          The path to the plugin core.
	 * @var     string         $url           The url to the plugin core folder.
	 */
	private $plugin_name,
            $loader,
            $path,
            $url;

	/**
	 * @access   private
	 * @since    0.6.0
	 */
    public function __construct($loader) {

		$this->plugin_name = MDYAM_PROJECT_NAME;
		$this->version = MDYAM_VERSION;
		$this->path = MDYAM_PROJECT_DIR;
		$this->loader = $loader;

    }

    /**
     * @access   public
     * @since    0.6.0
     * @param array $setup  Array of options.
     * @param array $fields Array of fields.
     */
    public function create_fieldset($setup, $fields) {
        $fieldset = new MD_YAM_Fieldset($this->loader);
        $fieldset->setup($setup);
        $fieldset->add_fields($fields);
        $fieldset->run();
    }

}
