<?php
// Field options
$options = '';
if ( isset($meta['options']['placeholder']) ) {
    $options .= ' placeholder="' . $meta['options']['placeholder'] . '"';
}
if ( isset($meta['options']['required']) ) {
    $options .= ' required="required"';
}

// Field classes
if ( isset($meta['options']['class']) ) {
    $class = $meta['options']['class'];
} else {
    $class = 'regular-text';
}

// Button classes
if ( isset($meta['options']['button_class']) ) {
    $button_class = $meta['options']['button_class'];
} else {
    $button_class = 'button button-secondary md-imagepicker-button';
}

// Value type
if ( isset($meta['options']['value_type']) ) {
    $value_type = $meta['options']['value_type'];
} else {
    $value_type = 'id';
}

// Get image url
if ( $meta['value'] != '' ) {
    if ( $value_type === 'id' ) {
        $image_url = wp_get_attachment_thumb_url($meta['value']);
    } else {
        $image_url = $meta['value'];
    }
}
?>
<tr>
    <th scope="row">
        <?=$meta['title'];?>
    </th>
    <td>
        <div class="md-imagepicker-container" id="<?=$meta['id'];?>-image">
        <?php if ( isset($image_url) ) { ?>
            <img src="<?=$image_url;?>" style="max-width:100%;">
        <?php }?>
        </div>
        <input type="text" value="<?=$meta['value'];?>" name="<?=$meta['id'];?>" id="<?=$meta['id'];?>" class="<?=$class;?>"<?=$options;?>><br>
        <button value="<?=$meta['value'];?>"
                class="<?=$button_class;?>"
                data-value-type="<?=$value_type;?>"
                data-image-container="#<?=$meta['id'];?>-image"
                data-target="#<?=$meta['id'];?>"
                data-mdyam="filepicker">
            <?php _e('Select image', 'md-yam'); ?>
        </button>
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
