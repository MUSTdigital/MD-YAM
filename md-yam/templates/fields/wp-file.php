<?php
// Field options
$options = '';
if ( isset($field['options']['placeholder']) ) {
    $options .= ' placeholder="' . esc_attr($field['options']['placeholder']) . '"';
}
if ( isset($field['options']['required']) ) {
    $options .= ' required="required"';
}

// Field classes
if ( isset($field['options']['class']) ) {
    $class = esc_attr($field['options']['class']);
} else {
    $class = 'regular-text';
}

// Button classes
if ( isset($field['options']['button_class']) ) {
    $button_class = esc_attr($field['options']['button_class']);
} else {
    $button_class = 'button button-secondary md-filepicker-button';
}

// Value type
if ( isset($field['options']['value_type']) ) {
    $value_type = esc_attr($field['options']['value_type']);
} else {
    $value_type = 'url';
}
?>
<tr>
    <th scope="row">
        <label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label>
    </th>
    <td>
        <input type="text" value="<?=esc_attr($field['value']);?>" name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>" class="<?=$class;?>"<?=$options;?>><br>
        <button value="<?=$field['value'];?>"
                class="<?=$button_class;?>"
                data-value-type="<?=$value_type;?>"
                data-target="#<?=esc_attr($field['id']);?>"
                data-mdyam="filepicker">
            <?php _e('Select file', 'md-yam'); ?>
        </button>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
