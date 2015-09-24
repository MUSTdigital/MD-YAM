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
    $button_class = 'button button-secondary md-imagepicker-button';
}

// Value type
if ( isset($field['options']['value_type']) ) {
    $value_type = $field['options']['value_type'];
} else {
    $value_type = 'id';
}

// Get image url
if ( $field['value'] != '' ) {
    if ( $value_type === 'id' ) {
        $image_url = wp_get_attachment_thumb_url($field['value']);
    } else {
        $image_url = $field['value'];
    }
}
?>
<tr>
    <th scope="row">
        <label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label>
    </th>
    <td>
        <div class="md-imagepicker-container" id="<?=esc_attr($field['id']);?>-image">
        <?php if ( isset($image_url) ) { ?>
            <img src="<?=$image_url;?>" style="max-width:100%;">
        <?php }?>
        </div>
        <input type="text" value="<?=esc_attr($field['value']);?>" name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>" class="<?=$class;?>"<?=$options;?>><br>
        <button value="<?=$field['value'];?>"
                class="<?=$button_class;?>"
                data-value-type="<?=esc_attr($value_type);?>"
                data-image-container="#<?=esc_attr($field['id']);?>-image"
                data-target="#<?=esc_attr($field['id']);?>"
                data-mdyam="filepicker">
            <?php _e('Select image', 'md-yam'); ?>
        </button>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
