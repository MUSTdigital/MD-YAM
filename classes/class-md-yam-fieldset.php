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
	 * @since   0.5.0
	 * @access  private
	 * @var     MD_YAM_Loader  $loader        Maintains and registers all hooks for the plugin.
	 * @var     string         $plugin_name  The ID of this plugin.
	 * @var     array          $fields        Array of fields.
	 * @var     WP_Post        $post          Current post object.
	 * @var     string         $path          The path to the plugin core.
	 * @var     string         $url           The url to the plugin core folder.
	 */
	private $loader,
            $plugin_name,
            $fields,
            $post,
            $path,
            $url;


	/**
	 * @since   0.5.47
	 * @access  private
	 * @var     array  $flags  Array of field types.
	 */
	private $flags;

	/**
	 * @since   0.5.8
	 * @access  private
	 * @var     array  $scripts  Scripts needed to be enqueued.
	 * @var     array  $styles   Styles needed to be enqueued.
	 */
	private $scripts,
            $styles;

	/**
	 * Common properties.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string       $meta_title  Title of the metabox.
	 * @var      string       $meta_id     Unique ID of a fieldset.
	 * @var      string|bool  $meta_group  Group name. Should be unique. If $meta_group === true, it will be equal to $meta_id.
	 * @var      bool         $meta_thin   Set to TRUE to use thin styles.
	 * @var      string       $meta_type   Type of a fieldset.
	 */
	private $meta_title,
            $meta_id,
            $meta_group,
            $meta_thin,
            $meta_type;

	/**
	 * Metabox properties.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string     $meta_post_type  Post type slug.
	 * @var      int|array  $meta_post_id    ID of a particular post where metabox should be shown.
	 * @var      string     $meta_context    The part of the page where the edit screen section should be shown.
	 */
	private $meta_post_type,
            $meta_post_id,
	        $meta_context;


	/**
	 * Options pages properties.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string   $meta_parent       The slug name for the parent menu.
	 * @var      string   $meta_short_title  The on-screen name text for the menu.
	 * @var      string   $meta_capability   The capability required for menu to be displayed to the user.
	 * @var      string   $meta_icon         The icon for this menu.
	 * @var      string   $meta_position     The position in the menu order this menu should appear. Default: bottom of menu structure.
	 */
    private $meta_parent,
            $meta_short_title,
            $meta_capability,
            $meta_icon,
            $meta_position;

    /**
     * Public properties used by class, which may be useful for development.
     *
	 * @since    0.5.0
	 * @access   public
	 * @var      array    $tree  Array of fields with some helper items. Accessable after add_fields method is used.
	 * @var      array    $tabs  Array of tabs. Accessable after add_fields method is used.
	 */
    public $tree,
           $tabs;

    /**
	 * @since    0.5.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 * @param      string    $loader    Loader object
	 */
	public function __construct($loader) {

		$this->plugin_name = MDYAM_PROJECT_NAME;
		$this->version = MDYAM_VERSION;
		$this->path = MDYAM_PROJECT_DIR;
		$this->url = MDYAM_PROJECT_URL;
		$this->loader = $loader;

        /**
         * Pre-setup defaults.
         */
        $this->meta_group      = NULL;
        $this->meta_thin       = false;
        $this->meta_type       = 'metabox';
        $this->meta_post_type  = NULL;
        $this->meta_post_id    = NULL;
        $this->meta_context    = 'advanced';
        $this->meta_capability = 'manage_options';
        $this->meta_icon       = '';
        $this->meta_position   = NULL;

	}

    /**
     * Public method to setup fieldset properties.
     *
     * @param  array  $options  Array of options.
     */
    public function setup( $options ) {

        foreach( $options as $key => $value ){

            if ( !property_exists( $this, 'meta_' . $key ) ) {
                throw new Exception( 'Undefined property "' . $key . '"' );
            }

            $name = 'meta_' . $key;
            $this->{$name} = $value;

        }

        /**
         * Setup other defaults if needed.
         */
        if ($this->meta_group === true) {
            $this->meta_group = $this->meta_id;
        }
        if ( !$this->meta_short_title ) {
            $this->meta_short_title = $this->meta_title;
        }

    }

    /**
     * Public method to add new fields.
     *
     * @param array $fields Array of fields.
     */
    public function add_fields( $fields ) {

        foreach( $fields as $field ){
            $this->fields[] = $field;
        }

        $this->rebuild_tree();
        $this->check_scripts();

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

        $total_fields = count( $this->fields );

        $tab_slug = $this->plugin_name . '_' . $this->meta_id . '_tab_';
        $block_slug = $this->plugin_name . '_' . $this->meta_id . '_block_';

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

        $this->tree = $tree;
        $this->tabs = $tabs;

    }

    /**
     * Creates arrays of scripts and styles needed to be enqueued.
     *
     * @since    0.5.8
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
                    $this->scripts[] = $this->plugin_name . '-iconpicker';
                    $this->styles[]  = $this->plugin_name . '-iconpicker';
                    break;

                case ('wp-file'):
                case ('wp-image'):
                    $this->scripts[] = $this->plugin_name . '-filepicker';
                    $this->styles[]  = $this->plugin_name . '-filepicker';
                    break;

                case ('code-editor'):
                    $this->scripts[] = $this->plugin_name . '-ace';
                    $this->styles[] = $this->plugin_name . '-ace';

                default:
                    break;

            }

        }

    }

    /**
     * Enqueues styles and scripts for metabox.
     *
     * @since 0.5.8
     */
    public function enqueue_metabox_scripts() {

        if (!$this->check_post()) {
            return;
        }

        foreach($this->scripts as $script){
            wp_enqueue_script($script);
        }

        foreach($this->styles as $style){
            wp_enqueue_style($style);
        }

    }

    /**
     * Enqueues styles and scripts for dashboard.
     *
     * @since 0.5.8
     */
    public function enqueue_dashboard_scripts($hook) {

        if ( 'index.php' != $hook ) {
            return;
        }

        if ( array_key_exists('wp-file', $this->flags) || array_key_exists('wp-image', $this->flags)) {
            wp_enqueue_media();
        }

        foreach($this->scripts as $script){
            wp_enqueue_script($script);
        }

        foreach($this->styles as $style){
            wp_enqueue_style($style);
        }

    }

    /**
     * Enqueues styles and scripts for admin menu pages.
     *
     * @since 0.5.8
     */
    public function enqueue_menupage_scripts($hook) {

        if ( strpos( $hook, $this->meta_id ) == false) {
            return;
        }

        if ( array_key_exists('wp-file', $this->flags) || array_key_exists('wp-image', $this->flags)) {
            wp_enqueue_media();
        }

        foreach($this->scripts as $script){
            wp_enqueue_script($script);

        }

        foreach($this->styles as $style){
            wp_enqueue_style($style);
        }

    }

    /**
     * Defines hooks.
     *
     * @since 0.5.0
     */
    private function define_hooks() {

        switch ($this->meta_type) {

            case ('metabox'):
                $this->loader->add_action( 'add_meta_boxes', $this, 'add_meta_box' );
                $this->loader->add_action( 'save_post', $this, 'save_meta' );
                $this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_metabox_scripts' );
                break;

            case ('dashboard'):
                $this->loader->add_action( 'wp_dashboard_setup', $this, 'add_dashboard_widget' );
                $this->loader->add_action( 'wp_ajax_md_yam_save_options', $this, 'ajax_save_options' );
                $this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_dashboard_scripts' );
                break;

            case ('menu_page'):
            case ('submenu_page'):
                $this->loader->add_action( 'admin_menu', $this, 'add_options_page' );
                $this->loader->add_action( 'wp_ajax_md_yam_save_options', $this, 'ajax_save_options' );
                $this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_menupage_scripts' );
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

        if ( isset($_POST['post_type']) && $this->meta_post_type == $_POST['post_type'] ) {

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
        ];

        $html = apply_filters( 'md_yam_generate_fieldset_template', $fields_html, $options );
        echo apply_filters( 'md_yam_fieldset_template', $html);

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
             || $meta['type'] == 'tab-start'
             || $meta['type'] == 'tab-end'
             || $meta['type'] == 'block-start'
             || $meta['type'] == 'block-end' ) {

            $meta['value'] = '';

        } elseif ( $meta['type'] == 'tabs-nav' ) {

            $meta['value'] = '';
            $meta['tabs'] = $this->tabs;

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

        if ( empty( $meta['value'] ) && !empty( $meta['default'] ) ) {
            $meta['value'] = $meta['default'];
        }

        $template = apply_filters( 'md_yam_generate_field_template', $meta );
        return apply_filters( 'md_yam_field_template', $template, $meta );
    }

    /**
     * Checks if curren edit screen matches post_id defined during setup.
     * @return boolean  true if match, false if doesn't.
     *
     * @since 0.5.8
     */
    private function check_post() {

        if (isset($_GET['post']) ) {
            $post_id = $_GET['post'];
        } elseif ( isset($_POST['post_ID']) ) {
            $post_id = $_POST['post_ID'];
        } else {
            if ($this->meta_post_id) {
                return false;
            }
        }

        if ( $this->meta_post_id ) {
            if ( is_array( $this->meta_post_id ) ) {
                if ( !in_array( $post_id, $this->meta_post_id ) ) {
                    return false;
                }
                return true;
            } else {
                if ( $post_id != $this->meta_post_id ) {
                    return false;
                }
                return true;
            }
        }

        return true;

    }

	/**
	 * Defines hooks and runs the loader.
	 *
	 * @since    0.5.0
	 */
	public function run() {

        if (!$this->check_post()) {
            return;
        }

        $this->define_hooks();

	}

}
