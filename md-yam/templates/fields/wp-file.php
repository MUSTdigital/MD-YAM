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
    'value_type' => 'url'
];
$options = wp_parse_args( isset($field['options']) ? $field['options'] : [], $default_options );
?>
<tr class="md_yam-<?=$field['type'];?>">
    <th scope="row">
        <label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label>
    </th>
    <td>
        <input type="text" value="<?=esc_attr($field['value']);?>" name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>" <?=$attrs;?>><br>
        <button value="<?=esc_attr($field['value']);?>"
                class="button button-secondary md-filepicker-button"
                data-value-type="<?=esc_attr($options['value_type']);?>"
                data-target="#<?=esc_attr($field['id']);?>"
                data-mdyam="filepicker">
            <?php _e('Select file', 'md-yam'); ?>
        </button>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
