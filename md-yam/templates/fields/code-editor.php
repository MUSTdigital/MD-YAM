<?php
// Editor sizes
$style = '';
if ( isset($field['options']['width']) ) {
    $style .= 'width: ' . $field['options']['width'] . '; ';
}
if ( isset($field['options']['height']) ) {
    $style .= 'height: ' . $field['options']['height'] . '; ';
}

// Editor options
$language = '';
$theme = '';
if ( isset($field['options']['language']) ) {
    $language = esc_attr($field['options']['language']);
}
if ( isset($field['options']['theme']) ) {
    $theme = esc_attr($field['options']['theme']);
}

// Container classes.
if ( isset($field['options']['class']) ) {
    $class = esc_attr($field['options']['class']);
}
?>
<tr>
    <th scope="row"><?=$field['title'];?></th>
    <td>
        <div class="md-codeeditor-container <?=$class;?>" style="<?=esc_attr($style);?>">
            <input type="hidden" name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>-input" value="<?=esc_attr($field['value']);?>">
            <div class="md-codeeditor"
                 id="<?=esc_attr($field['id']);?>"
                 data-mdyam="code-editor"
                 data-language="<?=$language;?>"
                 data-theme="<?=$theme;?>"
                 data-input="#<?=esc_attr($field['id']);?>-input"><?=esc_textarea($field['value']);?></div>
        </div>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
