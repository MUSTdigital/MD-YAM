<?php

/**
 * Fieldset generator.
 *
 * @link       http://mustdigital.ru
 * @since      0.5.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/fieldset
 */

/**
 * Class responsible for processing and generating fieldsets.
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/fieldset
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Fieldset {

	/**
	 * @access  private
	 * @var     array    $fields   Array of fields.
	 * @var     array    $flags    Array of field types.
	 * @var     array    $options  Array of options.
	 * @var     WP_Post  $post     Current post object.
	 * @var     array    $tree     Array of fields with some helper items. Accessable after add_fields method is used.
	 * @var     array    $tabs     Array of tabs. Accessable after add_fields method is used.
	 * @var     array    $scripts  Scripts needed to be enqueued.
	 * @var     array    $styles   Styles needed to be enqueued.
	 * @since   0.5.0
	 * @since   0.5.47   Added $flags
	 * @since   0.5.8    Added $scripts and $styles
	 * @since   0.6.2    Added $fields
	 * @since   0.6.3    Added $options
	 */
	private $fields,
            $options,
            $flags,
            $object,
            $tree,
            $tabs,
            $scripts,
            $styles;

    /**
     * @param  array  $options  Array of options.
     * @param  array  $fields   Array of fields.
	 * @since  0.5.0
	 */
	public function __construct( $options, $fields ) {

		$this->options = $options;
		$this->fields   = $fields;

        $this->setup();
        $this->rebuild_tree();
        $this->check_scripts();

    }

    /**
     * Setup fieldset properties.
     *
     * @access  public
     */
    private function setup() {

        $defaults = [
            // Common
            'title'     => false,
            'id'        => false,
            'group'     => false,
            'group_val' => false,
            'thin'      => false,
            'type'      => 'postmeta',

            // Postmeta
            'post_type' => null,
            'post_id'   => false,
	        'context'   => 'advanced',

            // Usermeta
            'user_id'   => false,

            // Options page
            'parent_slug' => 'options-general.php',
            'menu_title'  => false,
            'capability'  => 'manage_options',
            'icon_url'    => '',
            'position'    => null

        ];

        $this->options = wp_parse_args($this->options, $defaults);

        if ( !$this->options['title'] ) {
            throw new Exception( __( 'Title of the fieldset is not defined.', 'md-yam' ) );
        }

        if ( !$this->options['id'] ) {
            throw new Exception( __( 'ID of the fieldset is not defined.', 'md-yam' ) );
        }

        // Setup other defaults if needed.
        if ( $this->options['group'] === true ) {
            $this->options['group'] = $this->options['id'];
        }
        if ( !$this->options['menu_title'] ) {
            $this->options['menu_title'] = $this->options['title'];
        }

    }


    /**
     * Creates an array of fields, blocks and tabs.
     *
     * @access  private
     * @since   0.5.0
     */
    private function rebuild_tree() {

        $tree   = [];
        $tabs   = [];
        $fields = [];

        $current_tab   = -1;
        $current_block = -1;

        $in_block = false;
        $in_tab   = false;

        $total_fields = count( $this->fields );

        $tab_slug = MDYAM_PROJECT_NAME . '_' . $this->options['id'] . '_tab_';
        $block_slug = MDYAM_PROJECT_NAME . '_' . $this->options['id'] . '_block_';

        for ( $i = 0; $i < $total_fields; ++$i ) {

            $this->flags[$this->fields[$i]['type']] = true;

            // Tabs
            if ( $this->fields[$i]['type'] == 'tab' ) {

                // If there is a block already - close it.
                if ( $in_block === true ) {

                    $in_block = false;

                    $tree[] = [
                        'type' => 'block-end',
                    ];

                }

                // If there is a tab already - close it.
                if ( $in_tab === true ) {

                    $tree[] = [
                        'type' => 'tab-end',
                    ];

                // If this is a first tab, create tabs navigation.
                } else {

                    $tree[] = [
                        'type' => 'tabs-nav',
                    ];
                }

                $in_tab = true;
                $current_tab++;

                $tree[] = [
                    'type' => 'tab-start',
                    'id' => $tab_slug . $current_tab
                ];

                $tabs[] = [
                    'title' => $this->fields[$i]['title'],
                    'id' => $tab_slug . $current_tab
                ];

            // Headings
            } elseif ( $this->fields[$i]['type'] == 'heading' ) {

                // If there is a block already - close it.
                if ( $in_block === true ) {

                    $tree[] = [
                        'type' => 'block-end',
                    ];

                }

                $in_block = true;
                $current_block++;

                $tree[] = [
                    'type' => $this->fields[$i]['type'],
                    'title' => $this->fields[$i]['title'],
                    'id' => $block_slug . $current_block,
                    'options' => $this->fields[$i]['options']
                ];
                $tree[] = [
                    'type' => 'block-start',
                ];

            // Fields
            } else {

                // If there is no block - open one.
                if ( $in_block === false ) {

                    $in_block = true;
                    $current_block++;

                    $tree[] = [
                        'type' => 'block-start',
                    ];

                }

                $tree[] = $this->fields[$i];
                $fields[] = $this->fields[$i];

            }

            // Finally - add tab and block close items, if needed.
            if ( $i === $total_fields - 1) {

                // Close block if there is one opened.
                if ( $in_block === true ) {

                    $tree[] = [
                        'type' => 'block-end',
                    ];

                }

                // Close tab if there is one opened.
                if ( $in_tab === true ) {

                    $tree[] = [
                        'type' => 'tab-end',
                    ];

                }

            }

        }

        $this->tree   = $tree;
        $this->tabs   = $tabs;
        $this->fields = $fields;

    }

    /**
     * Creates arrays of scripts and styles needed to be enqueued.
     *
     * @access  private
     * @since   0.5.8
     */
    private function check_scripts() {

        $this->scripts = [];
        $this->styles  = [];

        foreach($this->flags as $flag => $val){

            switch ($flag) {

                case ('wp-color'):
                    $this->scripts[] = 'wp-color-picker';
                    $this->styles[]  = 'wp-color-picker';
                    break;

                case ('icon-picker'):
                    $this->scripts[] = MDYAM_PROJECT_NAME . '-iconpicker';
                    $this->styles[]  = MDYAM_PROJECT_NAME . '-iconpicker';
                    break;

                case ('wp-file'):
                case ('wp-image'):
                    $this->scripts[] = MDYAM_PROJECT_NAME . '-filepicker';
                    $this->styles[]  = MDYAM_PROJECT_NAME . '-filepicker';
                    break;

                case ('code-editor'):
                    $this->scripts[] = MDYAM_PROJECT_NAME . '-ace';
                    $this->styles[]  = MDYAM_PROJECT_NAME . '-ace';

                default:
                    break;

            }

        }

    }


	/**
	 * Adds fieldset to the admin menu page
	 *
	 * @access  public
	 * @since   0.6.2
	 */
	public function add_fieldset_listitem() {
        require MDYAM_PROJECT_DIR . 'assets/partitials/fieldset-table.php';
	}


	/**
	 * Echoes $this->html.
	 * Public for WP needs.
	 *
	 * @access  public
	 * @since   0.5.0
	 * @since   0.6.3 Combined with generate_html();
	 * @param   WP_Post $post The post object.
	 */
	public function render_content( $object = null) {

        $this->object = $object;

        foreach ( $this->tree as $field ) {
            $html .= $this->include_template( $field );
        }
        $html = apply_filters( 'md_yam_generate_fieldset_template', $html, $this->options );
        $this->html = apply_filters( 'md_yam_fieldset_template', $html);

        echo $this->html;

	}


    /**
     * Gets content of a particular field, prepares it,
     * includes a needed template file and returns the
     * rendered content.
     * Return string can be filtered via 'md_yam_field_template' filter.
     * @access  private
     * @param   array   $meta        Associative array representing the field.
     * @return  string  Rendered HTML.
     */
    private function include_template( $field ) {

        $object = $this->object;

        $field['value'] = '';

        switch ($field['type']) {
            case 'heading':
            case 'tab-start':
            case 'tab-end':
            case 'block-start':
            case 'block-end':
                break;

            case 'tabs-nav':
                $field['tabs']  = $this->tabs;
                break;

            default:

                if ( $this->options['group'] ) {

                    switch ($this->options['type']) {

                        case 'dashboard':
                        case 'menu_page':
                        case 'submenu_page':
                            $group_value = maybe_unserialize( get_option( $this->options['group'] ) );
                            break;

                        case 'postmeta':
                            $group_value = maybe_unserialize( get_post_meta( $object->ID, $this->options['group'], true ) );
                            break;

                        case 'usermeta':
                            $group_value = maybe_unserialize( get_user_meta( $object->ID, $this->options['group'], true ) );
                            break;
                    }

                    if (!$group_value) {
                        $group_value = [];
                    }

                    if ( array_key_exists( $field['name'], $group_value ) ) {
                        $field['value'] = $group_value[$field['name']];
                    }
                    $field['name'] = $this->options['group'] . '[' . $field['name'] . ']';

                } else {

                    switch ($this->options['type']) {

                        case 'dashboard':
                        case 'menu_page':
                        case 'submenu_page':
                            $field['value'] = get_option($field['name']);
                            break;

                        case 'postmeta':
                            $field['value'] = get_post_meta($object->ID, $field['name'], true);
                            break;

                        case 'usermeta':
                            $field['value'] = get_user_meta($object->ID, $field['name'], true);
                            break;
                    }

                }

                if ( empty( $field['value'] ) && !empty( $field['default'] ) ) {
                    $field['value'] = $field['default'];
                }
                $field['id'] = _md_yam_fix_id($field['name']);

                break;
        }

        $template = apply_filters( 'md_yam_generate_field_template', $field );
        return apply_filters( 'md_yam_field_template', $template, $field );
    }

    /**
     * Checks if curren edit screen matches object id defined during setup.
     *
     * @access  public
     * @since   0.5.8
     * @return boolean  true if match, false if doesn't.
     */
    public function check_object_id() {

        if ( $this->options['post_id'] || $this->options['user_id'] ) {

            if ( $this->options['post_id'] ) {
                $object_id = $this->options['post_id'];
            } elseif ($this->options['user_id']) {
                $object_id = $this->options['user_id'];
            }

            if (isset($_GET['post']) ) {
                $current_object_id = $_GET['post'];
            } elseif ( isset($_POST['post_ID']) ) {
                $current_object_id = $_POST['post_ID'];
            } elseif ( isset($_GET['user_id']) ) {
                $current_object_id = $_GET['user_id'];
            } elseif ( IS_PROFILE_PAGE === true ) {
                $current_object_id = wp_get_current_user()->ID;
            }

            if ( is_array($object_id) ) {
                if ( !in_array( $current_object_id, $object_id ) ) {
                    return false;
                }
            } else {
                if ( $current_object_id != $object_id ) {
                    return false;
                }
            }

        }

        return true;

    }

	/**
	 * @access  public
	 * @since   0.6.3
	 * @param   $var   Variable to return.
	 * @return  mixed  Requested variable.
	 */
	public function get_var($var) {
        $available = ['options', 'scripts', 'styles', 'fields', 'flags'];
        if ( in_array($var, $available) ) {
		  return $this->$var;
        } else {
            throw new Exception($var . ' is not available.');
        }
	}
}
