<?php
// Field attributes
$default_attributes = [
    'cols' => 45,
    'rows' => 5,
    'class' => isset($field['class']) ? $field['class'] : ''
];
$attributes = wp_parse_args( isset($field['attributes']) ? $field['attributes'] : [], $default_attributes );
$attrs = '';
foreach( $attributes as $key => $value ){
    $attrs .= ' ' . $key . '="' . esc_attr($value)  . '"';
}
?>
<tr class="md_yam-<?=$field['type'];?>">
    <th scope="row"><label for="<?=esc_attr($field['id']);?>'"><?=$field['title'];?></label></th>
    <td>
        <p>
            <textarea name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>" <?=$attrs;?>><?=esc_textarea($field['value']);?></textarea>
        </p>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
