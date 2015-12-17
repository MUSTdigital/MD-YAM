<?php
    $edit = isset($_GET['action']) && $_GET['action'] == 'edit';
?>
<<?=($edit ? 'tr' : 'div');?> class="form-field md_yam_fieldset md_yam_termmeta md_yam_usermeta_<?=$options['context'];?><?=($options['thin'] || !$edit ? ' md_yam_force_thin' : '');?>" id="<?=md5($options['id']);?>">
    <?=($edit ? '<td colspan="2" style="padding: 0;">' : '');?>
        <?php
            wp_nonce_field(
                'save_termmeta_' . $options['id'],
                '_wpnonce_md_yam' . $options['id'],
                true
            );
        ?>
        <?=$fields_html;?>
    <?=($edit ? '</td>' : '');?>
</<?=($edit ? 'tr' : 'div');?>>
