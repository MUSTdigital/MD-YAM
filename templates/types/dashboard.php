<form action="<?=$_SERVER['REQUEST_URI'];?>" class="md_yam_fieldset md_yam_dashboard_widget<?=($options['thin'] ? ' md_yam_force_thin' : '');?>" id="<?=md5($options['id']);?>">
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
    <p class="submit">
        <?php
            wp_nonce_field(
                'save_options_' . $options['id'],
                '_wpnonce_md_yam' . $options['id'],
                true
            );
        ?>
        <input type="hidden" name="action" value="md_yam_save_options">
        <input type="submit" name="save" class="button button-primary js_md_yam_save_options" value="Сохранить" data-id="<?=md5($options['id']);?>">
        <br class="clear">
    </p>
</form>
