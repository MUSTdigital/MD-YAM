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
?>
<tr>
    <th scope="row"><?=$field['title'];?></th>
    <td>
        <fieldset>
            <legend class="screen-reader-text"><span><?=$field['title'];?></span></legend>
            <?php foreach ( $field['values'] as $key => $value ) { ?>
            <label title="<?=esc_attr($key);?>">
                <input type="radio" name="<?=esc_attr($field['name']);?>" value="<?=esc_attr($key);?>" <?php checked($field['value'], $key);?> <?=$attrs;?>> <?=$value;?>
            </label>
            <?php } ?>
        </fieldset>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
