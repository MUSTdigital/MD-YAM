<?php

/**
 * Contains user meta actions.
 *
 * @link       http://mustdigital.ru
 * @since      0.6.3
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/fieldset
 */

/**
 * Contains user meta actions.
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/fieldset
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Usermeta {

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
        $this->flags    = $fieldset->get_var('flags');
        $this->options  = $fieldset->get_var('options');
        $this->scripts  = $fieldset->get_var('scripts');
        $this->styles   = $fieldset->get_var('styles');

    }

    /**
     * Enqueues styles and scripts for post metabox.
     * Public for WP needs.
     *
     * @access  public
     * @since   0.6.3
     */
    public function enqueue_usermeta_scripts() {

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
	 * Adds the meta box container. (Set as public because of WP needs, do not use in code.)
	 *
	 * @since 0.5.0
	 */
	public function add_meta_fields() {

        global $profileuser;
        $this->fieldset->render_content( $profileuser );

	}

    /**
	 * Save the meta when the post is saved.
	 * Public for WP needs.
	 *
	 * @param int $user_id The ID of the user being saved.
     * @since 0.5.0
	 */
	public function save_meta( $user_id = '' ) {

		if ( ! isset( $_POST['_wpnonce_md_yam' . $this->options['id']] ) ) {
			return $user_id;
        }

		$nonce = $_POST['_wpnonce_md_yam' . $this->options['id']];

		if ( ! wp_verify_nonce( $nonce, 'save_usermeta_' . $this->options['id'] ) ) {
			return $user_id;
        }

        if ( ! current_user_can( 'edit_user', $user_id ) ) {
            return $user_id;
        }

        if ( $this->options['group'] != NULL ) {

            if( isset( $_POST[$this->options['group']] ) && $_POST[$this->options['group']] != '' )  {
                $data = $_POST[$this->options['group']];
                update_user_meta( $user_id, $this->options['group'], $data );
            } else {
                delete_user_meta( $user_id, $this->options['group'] );
            }

        } else {

             foreach ( $this->fields as $meta ) {

                if( isset( $_POST[$meta['name']] ) && $_POST[$meta['name']] != '' )  {
                    $data = $_POST[$meta['name']];
                    update_user_meta( $user_id, $meta['name'], $data );
                } else {
                    delete_user_meta( $user_id, $meta['name'] );
                }

            }

        }

	}

}
