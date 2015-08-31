<div class="md_yam_fieldset md_yam_metabox md_yam_metabox_<?=$options['context'];?><?=($options['thin'] ? ' md_yam_force_thin' : '');?>" id="<?=md5($options['id']);?>">
    <?php
        wp_nonce_field(
            'save_metabox_' . $options['id'],
            '_wpnonce_md_yam' . $options['id'],
            true
        );
    ?>
    <?php
        if ( count( $options['tabs'] ) > 0 ) {

            $template = '/templates/tabs.php';
            if ( file_exists( $this->path . $template ) ) {
                include $this->path . $template;
            } else {
                echo 'No template: ' . $this->path . $template;
            }

        }
    ?>
    <?=$fields_html;?>
</div>
