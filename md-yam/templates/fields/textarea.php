<?php

// Textarea options
$options = '';
if ( isset($field['options']['maxlength']) ) {
    $options .= ' maxlength="' . esc_attr($field['options']['maxlength']) . '"';
}
if ( isset($field['options']['placeholder']) ) {
    $options .= ' placeholder="' . esc_attr($field['options']['placeholder']) . '"';
}
if ( isset($field['options']['rows']) ) {
    $options .= ' rows="' . esc_attr($field['options']['rows']) . '"';
} else {
    $options .= ' rows="5"';
}
if ( isset($field['options']['wrap']) ) {
    $options .= ' wrap="' . esc_attr($field['options']['wrap']) . '"';
}
if ( isset($field['options']['cols']) ) {
    $options .= ' cols="' . esc_attr($field['options']['cols']) . '"';
} else {
    $options .= ' cols="40"';
}
if ( isset($field['options']['readonly']) ) {
    $options .= ' readonly="readonly"';
}
if ( isset($field['options']['required']) ) {
    $options .= ' required="required"';
}
if ( isset($field['options']['disabled']) ) {
    $options .= ' disabled="disabled"';
}

// Textares classes.
if ( isset($field['options']['class']) ) {
    $class = esc_attr($field['options']['class']);
}
?>
<tr>
    <th scope="row"><label for="<?=esc_attr($field['id']);?>'"><?=$field['title'];?></label></th>
    <td>
        <p>
            <textarea name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>" class="<?=$class;?>"<?=$options;?>><?=esc_textarea($field['value']);?></textarea>
        </p>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
