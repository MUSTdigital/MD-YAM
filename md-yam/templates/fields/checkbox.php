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

if ( !isset($field['values'] ) ) {
    $field['values'] = [$field['name'] => $field['name']];
}

if ( !$field['value'] ) {
    $field['value'] = [];
}

if ( !_md_is_assoc($field['values'])) {
    foreach( $field['values'] as $value ){
        $temp[$value] = $value;
    }
    $field['values'] = $temp;
}
?>
<tr class="md_yam-<?=$field['type'];?>">
    <th scope="row">
        <label><?=$field['title'];?></label>
    </th>
    <td>
        <fieldset>
            <legend class="screen-reader-text"><span><?=$field['title'];?></span></legend>
            <?php foreach ( $field['values'] as $key => $value ) { ?>
            <label title="<?=esc_attr($key);?>">
                <input type="checkbox" name="<?=esc_attr($field['name']);?>[]" value="<?=esc_attr($key);?>" <?php checked(in_array($key, $field['value']), true);?> <?=$attrs;?>> <?=$value;?>
            </label>
            <?php } ?>
        </fieldset>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
