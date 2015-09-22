<?php
// Field options
$options = '';
if ( isset($meta['options']['min']) ) {
    $options .= ' min="' . $meta['options']['min'] . '"';
}
if ( isset($meta['options']['max']) ) {
    $options .= ' max="' . $meta['options']['max'] . '"';
}
if ( isset($meta['options']['step']) ) {
    $options .= ' step="' . $meta['options']['step'] . '"';
}
if ( isset($meta['options']['size']) ) {
    $options .= ' size="' . $meta['options']['size'] . '"';
}
if ( isset($meta['options']['maxlength']) ) {
    $options .= ' maxlength="' . $meta['options']['maxlength'] . '"';
}
if ( isset($meta['options']['multiple']) ) {
    $options .= ' multiple="' . $meta['options']['multiple'] . '"';
}
if ( isset($meta['options']['placeholder']) ) {
    $options .= ' placeholder="' . $meta['options']['placeholder'] . '"';
}
if ( isset($meta['options']['pattern']) ) {
    $options .= ' pattern="' . $meta['options']['pattern'] . '"';
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

// Field classes
if ( isset($meta['options']['class']) ) {
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
        <input name="<?=$meta['id'];?>" type="<?=$meta['type'];?>" id="<?=$meta['id'];?>" value="<?=$meta['value'];?>" class="<?=$class;?>"<?=$options;?>>
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
