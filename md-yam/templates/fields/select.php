<?php
// Field attributes
$default_attributes = [
    'class' => isset($field['class']) ? $field['class'] : ''
];
$attributes = wp_parse_args( isset($field['attributes']) ? $field['attributes'] : [], $default_attributes );
$attrs = '';
foreach( $attributes as $key => $value ){
    $attrs .= ' ' . $key . '="' . esc_attr($value)  . '"';
}

if ( isset( $field['attributes']['multiple'] ) ) {
    $field['name'] = $field['name'] . '[]';
} else {
    $field['value'] = [$field['value']];
}

if ( !_md_is_assoc($field['values'])) {
    foreach( $field['values'] as $value ){
        $temp[$value] = $value;
    }
    $field['values'] = $temp;
}
?>
<tr class="md_yam-<?=$field['type'];?>">
    <th scope="row"><label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label></th>
    <td>
        <select name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>"<?=$attrs;?>>
            <option value=""><?php _e('-- Select --', 'md-yam'); ?></option>
        <?php foreach ( $field['values'] as $key => $value ) { ?>
            <option value="<?=esc_attr($key);?>" <?php selected(in_array($key, $field['value']), true);?>><?=$value;?></option>
        <?php } ?>
        </select>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
