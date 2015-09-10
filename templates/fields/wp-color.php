<?php
// Field options
$options = '';
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
        <input name="<?=$meta['id'];?>" type="text" id="<?=$meta['id'];?>" value="<?=$meta['value'];?>" class="<?=$class;?>"<?=$options;?> data-mdyam="wpcolorpicker">
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
