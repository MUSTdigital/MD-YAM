<?php
// Field options
$options = '';
if ( isset($field['options']['disabled']) ) {
    $options .= ' disabled="disabled"';
}

// Field classes
if ( isset($field['options']['class']) ) {
    $class = esc_attr($field['options']['class']);
} else {
    $class = 'regular-text';
}
?>
<tr>
    <th scope="row">
        <label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label>
    </th>
    <td>
        <input name="<?=esc_attr($field['name']);?>" type="text" id="<?=esc_attr($field['id']);?>" value="<?=$field['value'];?>" class="<?=$class;?>"<?=$options;?> data-mdyam="wpcolorpicker">
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
