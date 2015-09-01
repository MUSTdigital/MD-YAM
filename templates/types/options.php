<form action="<?=$_SERVER['REQUEST_URI'];?>" class="md_yam_fieldset md_yam_options<?=($options['thin'] ? ' md_yam_force_thin' : '');?>" id="<?=md5($options['id']);?>">
    <?=$fields_html;?>
    <p class="submit">
        <?php
            wp_nonce_field(
                'save_options_' . $options['id'],
                '_wpnonce_md_yam' . $options['id'],
                true
            );
        ?>
        <input type="hidden" name="action" value="md_yam_save_options">
        <input type="submit" name="save" class="button button-primary" value="Сохранить">
        <br class="clear">
    </p>
</form>
