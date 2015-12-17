<?php

/**
 * Contains term meta actions.
 *
 * @link       http://mustdigital.ru
 * @since      0.7.0
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 */

/**
 * Contains term meta actions.
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/classes
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Termmeta extends MD_YAM_Fieldset {

    /**
     * Enqueues styles and scripts for post metabox.
     * Public for WP needs.
     *
     * @access  public
     * @since   0.7.0
     */
    public function enqueue_termmeta_scripts() {

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
     * Adds fields to the the edit page.
     * Public for WP needs.
     *
     * @since 0.7.0
     */
    public function edit_meta_fields( $term ) {

        $this->render_content( $term );

    }

    /**
     * Adds fields to the add new term page.
     * Public for WP needs.
     *
     * @since 0.7.0
     */
    public function add_meta_fields() {

        $this->render_content();

    }

    /**
     * Save the meta when the post is saved.
     * Public for WP needs.
     *
     * @param int $term_id The ID of the term being saved.
     * @since 0.7.0
     */
    public function save_meta( $term_id = '' ) {

        if ( ! isset( $_POST['_wpnonce_md_yam' . $this->options['id']] ) ) {
            return $term_id;
        }

        $nonce = $_POST['_wpnonce_md_yam' . $this->options['id']];

        if ( ! wp_verify_nonce( $nonce, 'save_termmeta_' . $this->options['id'] ) ) {
            return $term_id;
        }

        if ( $this->options['group'] != NULL ) {

            if( isset( $_POST[$this->options['group']] ) && $_POST[$this->options['group']] != '' )  {
                $data = $_POST[$this->options['group']];
                update_term_meta( $term_id, $this->options['group'], $data );
            } else {
                delete_term_meta( $term_id, $this->options['group'] );
            }

        } else {

             foreach ( $this->fields as $meta ) {

                if( isset( $_POST[$meta['name']] ) && $_POST[$meta['name']] != '' )  {
                    $data = $_POST[$meta['name']];
                    update_term_meta( $term_id, $meta['name'], $data );
                } else {
                    delete_term_meta( $term_id, $meta['name'] );
                }

            }

        }

    }

}
