<?php
$options = '';
if ( $meta['options']['size'] != '' ) {
    $options .= ' size="' . $meta['options']['size'] . '"';
}
if ( $meta['options']['maxlength'] != '' ) {
    $options .= ' maxlength="' . $meta['options']['maxlength'] . '"';
}
if ( $meta['options']['multiple'] != '' ) {
    $options .= ' multiple="' . $meta['options']['multiple'] . '"';
}
if ( $meta['options']['placeholder'] != '' ) {
    $options .= ' placeholder="' . $meta['options']['placeholder'] . '"';
}
if ( $meta['options']['pattern'] != '' ) {
    $options .= ' pattern="' . $meta['options']['pattern'] . '"';
}
if ( $meta['options']['readonly'] != '' ) {
    $options .= ' readonly="readonly"';
}
if ( $meta['options']['required'] != '' ) {
    $options .= ' required="required"';
}
if ( $meta['options']['disabled'] != '' ) {
    $options .= ' disabled="disabled"';
}

// Field classes
if ( $meta['options']['class'] != '' ) {
    $class = $meta['options']['class'];
} else {
    $class = 'regular-text';
}
?>
<tr>
    <th scope="row">
        <label for="<?=$meta['id'];?>"><?=$meta['title'];?></label>
    </th>
    <td>
        <input name="<?=$meta['id'];?>" type="url" id="<?=$meta['id'];?>" value="<?=$meta['value'];?>" class="<?=$class;?>"<?=$options;?>>
        <?php if ($meta['description']) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
