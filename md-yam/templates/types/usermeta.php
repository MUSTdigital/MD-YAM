<div class="md_yam_fieldset md_yam_usermeta md_yam_usermeta_<?=$options['context'];?><?=($options['thin'] ? ' md_yam_force_thin' : '');?>" id="<?=md5($options['id']);?>">
    <?php
        wp_nonce_field(
            'save_termmeta_' . $options['id'],
            '_wpnonce_md_yam' . $options['id'],
            true
        );
    ?>
    <?=$fields_html;?>
</div>
