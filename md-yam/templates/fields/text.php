<?php
// Field options
$options = '';
if ( isset($field['options']['min']) ) {
    $options .= ' min="' . esc_attr($field['options']['min']) . '"';
}
if ( isset($field['options']['max']) ) {
    $options .= ' max="' . esc_attr($field['options']['max']) . '"';
}
if ( isset($field['options']['step']) ) {
    $options .= ' step="' . esc_attr($field['options']['step']) . '"';
}
if ( isset($field['options']['size']) ) {
    $options .= ' size="' . esc_attr($field['options']['size']) . '"';
}
if ( isset($field['options']['maxlength']) ) {
    $options .= ' maxlength="' . esc_attr($field['options']['maxlength']) . '"';
}
if ( isset($field['options']['multiple']) ) {
    $options .= ' multiple="' . esc_attr($field['options']['multiple']) . '"';
}
if ( isset($field['options']['placeholder']) ) {
    $options .= ' placeholder="' . esc_attr($field['options']['placeholder']) . '"';
}
if ( isset($field['options']['pattern']) ) {
    $options .= ' pattern="' . esc_attr($field['options']['pattern']) . '"';
}
if ( isset($field['options']['readonly']) ) {
    $options .= ' readonly="readonly"';
}
if ( isset($field['options']['required']) ) {
    $options .= ' required="required"';
}
if ( isset($field['options']['disabled']) ) {
    $options .= ' disabled="disabled"';
}

// Field classes
if ( isset($field['options']['class']) ) {
    $class = esc_attr($field['options']['class']);
} else {
    $class = 'regular-text';
}
?>
<tr>
    <th scope="row">
        <label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label>
    </th>
    <td>
        <input name="<?=esc_attr($field['name']);?>" type="<?=$field['type'];?>" id="<?=esc_attr($field['id']);?>" value="<?=esc_attr($field['value']);?>" class="<?=$class;?>"<?=$options;?>>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
