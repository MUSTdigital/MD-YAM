<?php

// Textarea options
$options = '';
if ( $meta['options']['maxlength'] != '' ) {
    $options .= ' maxlength="' . $meta['options']['maxlength'] . '"';
}
if ( $meta['options']['placeholder'] != '' ) {
    $options .= ' placeholder="' . $meta['options']['placeholder'] . '"';
}
if ( $meta['options']['rows'] != '' ) {
    $options .= ' rows="' . $meta['options']['rows'] . '"';
} else {
    $options .= ' rows="5"';
}
if ( $meta['options']['wrap'] != '' ) {
    $options .= ' wrap="' . $meta['options']['wrap'] . '"';
}
if ( $meta['options']['cols'] != '' ) {
    $options .= ' cols="' . $meta['options']['cols'] . '"';
} else {
    $options .= ' cols="40"';
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

// Textares classes.
if ( $meta['options']['class'] != '' ) {
    $class = $meta['options']['class'];
}
?>
<tr>
    <th scope="row"><label for="<?=$meta['id'];?>'"><?=$meta['title'];?></label></th>
    <td>
        <p>
            <textarea name="<?=$meta['id'];?>" id="<?=$meta['id'];?>" class="<?=$class;?>"<?=$options;?>><?=$meta['value'];?></textarea>
        </p>
        <?php if ($meta['description']) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
