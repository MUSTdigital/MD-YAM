<?php

/**
 * Contains metabox actions.
 *
 * @link       http://mustdigital.ru
 * @since      0.6.3
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/fieldset
 */

/**
 * Contains metabox actions.
 *
 * @package    MD_YAM
 * @subpackage MD_YAM/fieldset
 * @author     Dmitry Korolev <dk@mustdigital.ru>
 */
class MD_YAM_Postmeta {

	/**
	 * @access  private
	 * @var     MD_YAM_Fieldset  $fieldset  Contains all fieldset options.
	 * @var     array            $options   Array of options.
	 * @var     array            $scripts   Scripts needed to be enqueued.
	 * @var     array            $styles    Styles needed to be enqueued.
	 * @since   0.6.3
	 */
	private $fieldset,
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

    }

    /**
     * Enqueues styles and scripts for post metabox.
     * Public for WP needs.
     *
     * @access  public
     * @since   0.5.8
     */
    public function enqueue_postmeta_scripts() {

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
	public function add_meta_box() {

        add_meta_box(
            $this->options['id'],
            $this->options['title'],
            [ $this->fieldset, 'render_content' ],
            $this->options['post_type'],
            $this->options['context']
        );

	}

    /**
	 * Save the meta when the post is saved.
	 * Public for WP needs.
	 *
	 * @param int $post_id The ID of the post being saved.
     * @since 0.5.0
	 */
	public function save_meta( $post_id = '' ) {

		if ( ! isset( $_POST['_wpnonce_md_yam' . $this->options['id']] ) ) {
			return $post_id;
        }

		$nonce = $_POST['_wpnonce_md_yam' . $this->options['id']];

		if ( ! wp_verify_nonce( $nonce, 'save_postmeta_' . $this->options['id'] ) ) {
			return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( isset($_POST['post_type']) && $this->options['post_type'] == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }

        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }

        }

        if ( $this->options['group'] != NULL ) {

            if( isset( $_POST[$this->options['group']] ) && $_POST[$this->options['group']] != '' )  {
                $data = $_POST[$this->options['group']];
                update_post_meta( $post_id, $this->options['group'], $data );
            } else {
                delete_post_meta( $post_id, $this->options['group'] );
            }

        } else {

             foreach ( $this->fields as $meta ) {

                if( isset( $_POST[$meta['name']] ) && $_POST[$meta['name']] != '' )  {
                    $data = $_POST[$meta['name']];
                    update_post_meta( $post_id, $meta['name'], $data );
                } else {
                    delete_post_meta( $post_id, $meta['name'] );
                }

            }

        }

	}

}
