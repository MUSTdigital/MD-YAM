<?php
// Field attributes
$default_attributes = [
    'class' => isset($field['class']) ? $field['class'] : 'regular-text'
];
$attributes = wp_parse_args( isset($field['attributes']) ? $field['attributes'] : [], $default_attributes );
$attrs = '';
foreach( $attributes as $key => $value ){
    $attrs .= ' ' . $key . '="' . esc_attr($value)  . '"';
}

// Value type
$default_options = [
    'value_type' => 'id'
];
$options = wp_parse_args( isset($field['options']) ? $field['options'] : [], $default_options );

// Get image url
if ( $field['value'] != '' ) {
    if ( $options['value_type'] === 'id' ) {
        $image_url = wp_get_attachment_thumb_url($field['value']);
    } else {
        $image_url = $field['value'];
    }
}
?>
<tr class="md_yam-<?=$field['type'];?>">
    <th scope="row">
        <label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label>
    </th>
    <td>
        <div class="md-imagepicker-container" id="<?=esc_attr($field['id']);?>-image">
        <?php if ( isset($image_url) ) { ?>
            <img src="<?=$image_url;?>" style="max-width:100%;">
        <?php }?>
        </div>
        <input type="text" value="<?=esc_attr($field['value']);?>" name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>" <?=$attrs;?>><br>
        <button value="<?=esc_attr($field['value']);?>"
                class="button button-secondary md-imagepicker-button"
                data-value-type="<?=esc_attr($options['value_type']);?>"
                data-image-container="#<?=esc_attr($field['id']);?>-image"
                data-target="#<?=esc_attr($field['id']);?>"
                data-mdyam="filepicker">
            <?php _e('Select image', 'md-yam'); ?>
        </button>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
