<?php
$default_options = [
    'textarea_name' => $field['name'],
    'textarea_rows' => 5,

];
$options = wp_parse_args( isset($field['options']['tinymce']) ? $field['options']['tinymce'] : [], $default_options);
?>
<tr class="md_yam-<?=$field['type'];?>">
    <th scope="row"><label for="<?=esc_attr($field['id']);?>'"><?=$field['title'];?></label></th>
    <td>
        <?php wp_editor( $field['value'], $field['id'], $options ); ?>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
