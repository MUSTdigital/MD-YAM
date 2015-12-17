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
?>
<tr class="md_yam-<?=$field['type'];?>">
    <th scope="row">
        <label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label>
    </th>
    <td>
        <input name="<?=esc_attr($field['name']);?>" type="<?=$field['type'];?>" id="<?=esc_attr($field['id']);?>" value="<?=esc_attr($field['value']);?>" <?=$attrs;?>>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
