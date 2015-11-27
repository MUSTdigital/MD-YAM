<tr class="form-field md_yam_fieldset md_yam_termmeta md_yam_usermeta_<?=$options['context'];?><?=($options['thin'] ? ' md_yam_force_thin' : '');?>" id="<?=md5($options['id']);?>">
    <td colspan="2" style="padding: 0;">
        <?php
            wp_nonce_field(
                'save_termmeta_' . $options['id'],
                '_wpnonce_md_yam' . $options['id'],
                true
            );
        ?>
        <?=$fields_html;?>
    </td>
</tr>
