<?php
$options = '';
if ( isset($meta['options']['required']) ) {
    $options .= ' required="required"';
}
if ( isset($meta['options']['disabled']) ) {
    $options .= ' disabled="disabled"';
}
?>
<tr>
    <th scope="row">
        <label for="<?=$meta['id'];?>"><?=$meta['title'];?></label>
    </th>
    <td>
        <input name="<?=$meta['id'];?>" type="checkbox" value="1" id="<?=$meta['id'];?>" <?php checked($meta['value'], 1);?> <?=$options;?> >
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
