<?php
// Field attributes
$default_attributes = [
    'class' => isset($field['class']) ? $field['class'] : 'md-codeeditor-container',
    'style' => 'height: 200px; width: 100%; max-width: 800px;'
];
$attributes = wp_parse_args( isset($field['attributes']) ? $field['attributes'] : [], $default_attributes );
$attrs = '';
$styles = '';
foreach( $attributes as $key => $value ){
    $attrs .= ' ' . $key . '="' . esc_attr($value)  . '"';
}

//mdd($styles);
// Value type
$default_options = [
    'language' => 'text',
    'theme' => 'chrome'
];
$options = wp_parse_args( isset($field['options']) ? $field['options'] : [], $default_options );
?>
<tr class="md_yam-<?=$field['type'];?>">
    <th scope="row"><?=$field['title'];?></th>
    <td>
        <div <?=$attrs;?>>
            <input type="hidden" name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>-input" value="<?=esc_attr($field['value']);?>">
            <div class="md-codeeditor"
                 id="<?=esc_attr($field['id']);?>"
                 data-mdyam="code-editor"
                 data-language="<?=$options['language'];?>"
                 data-theme="<?=$options['theme'];?>"
                 data-input="#<?=esc_attr($field['id']);?>-input"><?=esc_textarea($field['value']);?></div>
        </div>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
