<?php

/**
 * Fieldset generator.
 *
 * @link       http://mustdigital.ru
 * @since      0.5.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 */

/**
 * Class responsible for generating fieldsets and seving metafields and options.
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Fieldset {

	/**
	 * @since    0.5.0
	 * @access   protected
	 * @var      MD_YAM_Loader    $loader    Maintains and registers all hooks for the project.
	 */
	private $loader;

    /**
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $project_name    The ID of this project.
	 */
	private $project_name;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $meta_title    Title of the fieldset.
	 */
	private $meta_title;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $meta_short_title    Short title, used as $menu_title in add_menu_page and add_submenu_page. Default: $menu_title.
	 */
	private $meta_short_title;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $meta_id    Unique ID of a fieldset.
	 */
	private $meta_id;

	/**
	 * Type of a fieldset. It could be metabox ('metabox', default),
	 * admin dashboard widget ('dashboard'), options page ('menu_page'), subpage ('submenu_page') or just html output ('html').
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $meta_type    Type of a fieldset.
	 */
	private $meta_type;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $meta_post_id    ID of particular post where metabox should be shown.
	 */
	private $meta_post_id;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $meta_post_type   Post type (built in or custom) where metabox should be shown. Optional.
	 */
	private $meta_post_type;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $meta_context   The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). Optional.
	 */
	private $meta_context;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $meta_capability   The capability required for menu to be displayed to the user. Defaults to 'manage_options'.
	 */
	private $meta_capability;

	/**
	 * Allows grouping of several metafields or options into one.
	 * If provided all fields will become elements of one meta_key or option, named after $meta_group.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string|bool    $meta_group   Group name. Should be unique. If $meta_group === true, it will be equal to $meta_id.
	 */
	private $meta_group;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      bool    $meta_thin   Set to TRUE to use thin styles.
	 */
    private $meta_thin;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      array    $meta_icon   Path to menu icon or dashicon class.
	 */
    private $meta_icon;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      array    $meta_parent   The slug name for the parent menu (or the file name of a standard WordPress admin page).
	 */
    private $meta_parent;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      array    $meta_position   The position in the menu order this menu should appear. Default: bottom of menu structure.
	 */
    private $meta_position;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      array    $fields   Array of fields.
	 */
    private $fields;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      array    $tree   Array of fields with some helper items.
	 */
    private $tree;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      array    $tabs   Array of tabs.
	 */
    private $tabs;

	/**
	 * @since    0.5.0
	 * @access   private
	 * @var      WP_Post    $post   Post object.
	 */
    private $post;

    /**
	 * @since    0.5.0
	 * @param      string    $project_name       The name of this project.
	 * @param      string    $version    The version of this project.
	 * @param      string    $loader    Loader object
	 */
	public function __construct() {

		$this->project_name = 'md-yam';
		$this->version = '0.5.0';

        $this->meta_post_type = NULL;
        $this->meta_context = 'advanced';
        $this->meta_type = 'metabox';
        $this->meta_group = NULL;
        $this->meta_capability = 'manage_options';
        $this->meta_icon = '';
        $this->meta_position = NULL;

		$this->load_dependencies();

	}

	/**
	 * Load the required dependencies for this class.
	 *
	 * Include the following files that make up the MD YAM:
	 *
	 * - MD_YAM_Loader. Orchestrates the hooks.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-md-yam-loader.php';

        $this->loader = new MD_YAM_Loader();

	}


    /**
     * @param array $options Array of options.
     */
    public function setup( $options ) {

        foreach( $options as $key => $value ){
            if ( !property_exists( $this, 'meta_' . $key ) ) {
                throw new Exception( 'Undefined property "' . $key . '"' );
            }
            $name = 'meta_' . $key;
            $this->{$name} = $value;
        }

        if ($this->meta_group === true) {
            $this->meta_group = $this->meta_id;
        }
        if ( !$this->meta_short_title ) {
            $this->meta_short_title = $this->meta_title;
        }

    }

    /**
     * @param array $fields Array of fields.
     */
    public function add_fields( $fields ) {

        foreach( $fields as $field ){
            $this->fields[] = $field;
        }

        $this->rebuild_tree();

    }


    /**
     * Defines hooks if needed.
     *
     * @since 0.5.0
     */
    private function define_hooks() {

        switch ($this->meta_type) {

            case ('metabox'):
                $this->loader->add_action( 'add_meta_boxes', $this, 'add_meta_box' );
                $this->loader->add_action( 'save_post', $this, 'save_meta' );
                break;

            case ('dashboard'):
                $this->loader->add_action( 'wp_dashboard_setup', $this, 'add_dashboard_widget' );
                $this->loader->add_action( 'wp_ajax_md_yam_save_options', $this, 'ajax_save_options' );
                break;

            case ('menu_page'):
            case ('submenu_page'):
                $this->loader->add_action( 'admin_menu', $this, 'add_options_page' );
                $this->loader->add_action( 'wp_ajax_md_yam_save_options', $this, 'ajax_save_options' );
                break;

            default:

                break;
        }

    }

	/**
	 * Adds the meta box container. (Set as public because of WP needs, do not use in code.)
	 *
	 * @since 0.5.0
	 */
	public function add_meta_box() {

        add_meta_box(
            $this->meta_id,
            $this->meta_title,
            [ $this, 'render_content' ],
            $this->meta_post_type,
            $this->meta_context
        );

	}

	/**
	 * Adds the widget to dashboard. (Set as public because of WP needs, do not use in code.)
	 *
	 * @since 0.5.0
	 */
	public function add_dashboard_widget() {

        wp_add_dashboard_widget(
            $this->meta_id,
            $this->meta_title,
            [ $this, 'render_content' ]
        );

	}

	/**
	 * Adds the page (or sub-page) to admin menu. (Set as public because of WP needs, do not use in code.)
	 *
	 * @since 0.5.0
	 */
	public function add_options_page() {

        if ( $this->meta_type == 'menu_page') {

            add_menu_page(
                $this->meta_title,
                $this->meta_short_title,
                $this->meta_capability,
                $this->meta_id,
                [ $this, 'render_content' ],
                $this->meta_icon,
                $this->meta_position
            );

        } elseif ( $this->meta_type == 'submenu_page') {

            add_submenu_page(
                $this->meta_parent,
                $this->meta_title,
                $this->meta_short_title,
                $this->meta_capability,
                $this->meta_id,
                [ $this, 'render_content' ]
            );

        }

	}

	/**
	 * Render Meta Box content. (Set as public because of WP needs, do not use in code.)
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_content( $post ) {

        $this->post = $post;

        $fields_html = $this->explode_meta_fields();

        $options = [
            'type' => $this->meta_type,
            'id' => $this->meta_id,
            'context' => $this->meta_context,
            'thin' => $this->meta_thin,
            'tabs' => $this->tabs
        ];

        $html = apply_filters( 'md_yam_generate_fieldset_template', $fields_html, $options );
        echo apply_filters( 'md_yam_fieldset_template', $html);

	}

    /**
	 * Save the meta when the post is saved. (Set as public because of WP needs, do not use in code.)
	 *
	 * @param int $post_id The ID of the post being saved.
     * @since 0.5.0
	 */
	public function save_meta( $post_id = '' ) {

		if ( ! isset( $_POST['_wpnonce_md_yam' . $this->meta_id] ) ) {
			return $post_id;
        }

		$nonce = $_POST['_wpnonce_md_yam' . $this->meta_id];

		if ( ! wp_verify_nonce( $nonce, 'save_metabox_' . $this->meta_id ) ) {
			return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( $this->post_type == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }

        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }

        }

        if ( $this->meta_group != NULL ) {

            if( isset( $_POST[$this->meta_group] ) && $_POST[$this->meta_group] != '' )  {
                $data = $_POST[$this->meta_group];
                update_post_meta( $post_id, $this->meta_group, maybe_serialize($data) );
            } else {
                delete_post_meta( $post_id, $this->meta_group );
            }

        } else {

             foreach ( $this->fields as $meta ) {

                if( isset( $_POST[$meta['id']] ) && $_POST[$meta['id']] != '' )  {
                    $data = $_POST[$meta['id']];
                    update_post_meta( $post_id, $meta['id'], $data );
                } else {
                    delete_post_meta( $post_id, $meta['id'] );
                }

            }

        }

	}

    /**
	 * Save options via AJAX.
	 *
	 * @param int $post_id The ID of the post being saved.
     * @since 0.5.0
	 */
	public function ajax_save_options() {

		if ( ! isset( $_POST['_wpnonce_md_yam' . $this->meta_id] ) ) {
			exit(json_encode([
                'result' => 'error',
                'message' => __( 'Nonce not set, can\'t save options.', 'md-yam')
            ]));
        }

		$nonce = $_POST['_wpnonce_md_yam' . $this->meta_id];

		if ( ! wp_verify_nonce( $nonce, 'save_options_' . $this->meta_id ) ) {
			exit(json_encode([
                'result' => 'error',
                'message' => __( 'Nonce can\'t be verified, can\'t save options.', 'md-yam')
            ]));
        }

        if ( ! current_user_can( $this->meta_capability, $post_id ) ) {
			exit(json_encode([
                'result' => 'error',
                'message' => __( 'You don\'t have enough capabilities to edit this options.', 'md-yam')
            ]));
        }

        if ( $this->meta_group != NULL ) {

            if( isset( $_POST[$this->meta_group] ) && $_POST[$this->meta_group] != '' )  {
                $data = $_POST[$this->meta_group];
                update_option( $this->meta_group, maybe_serialize($data) );
            } else {
                delete_option( $this->meta_group );
            }

        } else {

             foreach ( $this->fields as $meta ) {

                if( isset( $_POST[$meta['id']] ) && $_POST[$meta['id']] != '' )  {
                    $data = $_POST[$meta['id']];
                    update_option( $meta['id'], $data );
                } else {
                    delete_option( $meta['id'] );
                }

            }

        }

        exit(json_encode([
            'result' => 'ok',
            'message' => __( 'Options saved!', 'md-yam')
        ]));

	}

    /**
     * Creates an array of fields, blocks and tabs.
     *
     * @since    0.5.0
     */
    private function rebuild_tree() {

        $tree = [];
        $tabs = [];
        $current_tab = -1;
        $current_block = -1;
        $in_block = false;
        $in_tab = false;
        $total_items = count( $this->fields );

        $tab_slug = $this->project_name . '_' . $this->meta_id . '_tab_';
        $block_slug = $this->project_name . '_' . $this->meta_id . '_block_';

        for ( $i = 0; $i < $total_items; ++$i ) {

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

            }

            // Last iteration
            if ( $i === $total_items - 1) {

                // Close block if there is one opened
                if ( $in_block === true ) {

                    $tree[] = [
                        'type' => 'block-end',
                    ];

                }

                // Close tab if there is one opened
                if ( $in_tab === true ) {

                    $tree[] = [
                        'type' => 'tab-end',
                    ];

                }

            }

        }

        $this->tree = $tree;
        $this->tabs = $tabs;

    }

    /**
     * Returns html for meta fields.
     *
     * @param  WP_Post $post The post object.
     * @return string  $template String, containing fields html.
     * @since    0.5.0
     */
    private function explode_meta_fields() {

        $post = $this->post;

        $template = '';
        $group_key = NULL;
        $group_value = NULL;

        if ( $this->meta_group != NULL ) {

            $group_key = $this->meta_group;
            if ( $this->meta_type == 'menu_page' || $this->meta_type == 'submenu_page' || $this->meta_type == 'dashboard' ) {
                $group_value = maybe_unserialize( get_option( $group_key ) );
            } else {
                $group_value = maybe_unserialize( get_post_meta( $post->ID, $group_key, true ) );
            }

            if (!$group_value) {
                $group_value = [];
            }

        }


        foreach ( $this->tree as $item ) {

            $template .= $this->include_template($item, $group_key, $group_value);

        }

        return $template;

    }

    /**
     * Gets content of a particular field, prepares it,
     * includes a needed template file and returns the
     * rendered content.
     * Return string can be filtered via 'md_yam_field_template' filter.
     *
     * @param  WP_Post $post        Post object.
     * @param  array   $meta        Associative array representing the field.
     * @param  string  $group_key   Group key, if fieldset have one
     * @param  string  $group_value Group value (value of group meta_key or site_option)
     * @return string  Rendered HTML.
     */
    private function include_template( $meta, $group_key, $group_value ) {

        $post = $this->post;
        $meta['value'] = '';

        if ( $meta['type'] == 'heading'
             || $meta['type'] == 'tab'
             || $meta['type'] == 'tab-start'
             || $meta['type'] == 'tab-end'
             || $meta['type'] == 'block-start'
             || $meta['type'] == 'block-end' ) {

            $meta['value'] = '';

        } else {

            if ( $group_key ) {

                if ( array_key_exists( $meta['id'], $group_value ) ) {
                    $meta['value'] = $group_value[$meta['id']];
                } else {
                    $meta['value'] = '';
                }
                $meta['id'] = $group_key . '[' . $meta['id'] . ']';

            } else {

                if ( $this->meta_type == 'menu_page' || $this->meta_type == 'submenu_page' || $this->meta_type == 'dashboard' ) {

                    $meta['value'] = htmlspecialchars(get_option($meta['id']));

                } else {

                    $meta['value'] = htmlspecialchars(get_post_meta($post->ID, $meta['id'], true));

                }

            }

        }

        $template = apply_filters( 'md_yam_generate_field_template', $meta );
        return apply_filters( 'md_yam_field_template', $template, $meta );
    }

	/**
	 * Run the loader.
	 *
	 * @since    0.5.0
	 */
	public function run() {

        $this->define_hooks();
		$this->loader->run();

	}

}
