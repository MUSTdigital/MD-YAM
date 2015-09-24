<?php
$options = '';
if ( isset($field['options']['required']) ) {
    $options .= ' required="required"';
}
if ( isset($field['options']['disabled']) ) {
    $options .= ' disabled="disabled"';
}
?>
<tr>
    <th scope="row"><label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label></th>
    <td>
        <select name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>"<?=$options;?>>
            <option value=""><?php _e('-- Select --', 'md-yam'); ?></option>
        <?php foreach ( $field['values'] as $key => $value ) { ?>
            <option value="<?=esc_attr($key);?>" <?php selected($field['value'], $key);?>><?=$value;?></option>
        <?php } ?>
        </select>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
