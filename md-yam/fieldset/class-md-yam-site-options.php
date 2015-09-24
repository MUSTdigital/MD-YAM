<?php

/**
 * Contains options actions.
 *
 * @link       http://mustdigital.ru
 * @since      0.6.3
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/fieldset
 */

/**
 * Contains options actions.
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/fieldset
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Site_Options {

	/**
	 * @access  private
	 * @var     MD_YAM_Fieldset  $fieldset  Contains all fieldset options.
	 * @var     array            $flags     Array of field types.
	 * @var     array            $options   Array of options.
	 * @var     array            $scripts   Scripts needed to be enqueued.
	 * @var     array            $styles    Styles needed to be enqueued.
	 * @since   0.6.3
	 */
	private $fieldset,
            $flags,
            $options,
            $scripts,
            $styles;

    /**
     * @param  MD_YAM_Fieldset  $fieldset
	 * @since  0.6.3
	 */
	public function __construct( $fieldset ) {

        $this->fieldset = $fieldset;

        $this->fields   = $fieldset->get_var('fields');
        $this->options  = $fieldset->get_var('options');
        $this->scripts  = $fieldset->get_var('scripts');
        $this->styles   = $fieldset->get_var('styles');
        $this->flags    = $fieldset->get_var('flags');

    }

    /**
     * Enqueues styles and scripts for dashboard.
     * Public for WP needs.
     *
     * @access public
     * @since  0.5.8
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
     * Public for WP needs.
     *
     * @access  public
     * @since   0.5.8
     */
    public function enqueue_menupage_scripts($hook) {

        if ( strpos( $hook, $this->options['id'] ) == false) {
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
	 * Adds the widget to dashboard. (Set as public because of WP needs, do not use in code.)
	 *
	 * @since 0.5.0
	 */
	public function add_dashboard_widget() {

        wp_add_dashboard_widget(
            $this->options['id'],
            $this->options['title'],
            [ $this->fieldset, 'render_content' ]
        );

	}

	/**
	 * Adds the page (or sub-page) to admin menu. (Set as public because of WP needs, do not use in code.)
	 *
	 * @since 0.5.0
	 */
	public function add_options_page() {

        if ( $this->options['type'] == 'menu_page') {

            add_menu_page(
                $this->options['title'],
                $this->options['menu_title'],
                $this->options['capability'],
                $this->options['id'],
                [ $this->fieldset, 'render_content' ],
                $this->options['icon_url'],
                $this->options['position']
            );

        } elseif ( $this->options['type'] == 'submenu_page') {

            add_submenu_page(
                $this->options['parent'],
                $this->options['title'],
                $this->options['menu_title'],
                $this->options['capability'],
                $this->options['id'],
                [ $this->fieldset, 'render_content' ]
            );

        }

	}

    /**
	 * Save options via AJAX.
	 *
	 * @param int $post_id The ID of the post being saved.
     * @since 0.5.0
	 */
	public function ajax_save_options() {

		if ( ! isset( $_POST['_wpnonce_md_yam' . $this->options['id']] ) ) {
			exit(json_encode([
                'result' => 'error',
                'message' => __( 'Nonce not set, can\'t save options.', 'md-yam')
            ]));
        }

		$nonce = $_POST['_wpnonce_md_yam' . $this->options['id']];

		if ( ! wp_verify_nonce( $nonce, 'save_options_' . $this->options['id'] ) ) {
			exit(json_encode([
                'result' => 'error',
                'message' => __( 'Nonce can\'t be verified, can\'t save options.', 'md-yam')
            ]));
        }

        if ( ! current_user_can( $this->options['capability'] ) ) {
			exit(json_encode([
                'result' => 'error',
                'message' => __( 'You don\'t have enough capabilities to edit this options.', 'md-yam')
            ]));
        }

        if ( $this->options['group'] != NULL ) {

            if( isset( $_POST[$this->options['group']] ) && $_POST[$this->options['group']] != '' )  {
                $data = $_POST[$this->options['group']];
                update_option( $this->options['group'], maybe_serialize($data) );
            } else {
                delete_option( $this->options['group'] );
            }

        } else {

             foreach ( $this->fields as $meta ) {

                if( isset( $_POST[$meta['name']] ) && $_POST[$meta['name']] != '' )  {
                    $data = $_POST[$meta['name']];
                    update_option( $meta['name'], $data );
                } else {
                    delete_option( $meta['name'] );
                }

            }

        }

        exit(json_encode([
            'result' => 'ok',
            'message' => __( 'Options saved!', 'md-yam')
        ]));

	}

}
