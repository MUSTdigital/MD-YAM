<?php

// Textarea options
$options = '';
if ( isset($meta['options']['maxlength']) ) {
    $options .= ' maxlength="' . $meta['options']['maxlength'] . '"';
}
if ( isset($meta['options']['placeholder']) ) {
    $options .= ' placeholder="' . $meta['options']['placeholder'] . '"';
}
if ( isset($meta['options']['rows']) ) {
    $options .= ' rows="' . $meta['options']['rows'] . '"';
} else {
    $options .= ' rows="5"';
}
if ( isset($meta['options']['wrap']) ) {
    $options .= ' wrap="' . $meta['options']['wrap'] . '"';
}
if ( isset($meta['options']['cols']) ) {
    $options .= ' cols="' . $meta['options']['cols'] . '"';
} else {
    $options .= ' cols="40"';
}
if ( isset($meta['options']['readonly']) ) {
    $options .= ' readonly="readonly"';
}
if ( isset($meta['options']['required']) ) {
    $options .= ' required="required"';
}
if ( isset($meta['options']['disabled']) ) {
    $options .= ' disabled="disabled"';
}

// Textares classes.
if ( isset($meta['options']['class']) ) {
    $class = $meta['options']['class'];
}
?>
<tr>
    <th scope="row"><label for="<?=$meta['id'];?>'"><?=$meta['title'];?></label></th>
    <td>
        <p>
            <textarea name="<?=$meta['id'];?>" id="<?=$meta['id'];?>" class="<?=$class;?>"<?=$options;?>><?=$meta['value'];?></textarea>
        </p>
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
