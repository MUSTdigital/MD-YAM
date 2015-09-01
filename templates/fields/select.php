<?php
$options = '';
if ( $meta['options']['required'] != '' ) {
    $options .= ' required="required"';
}
if ( $meta['options']['disabled'] != '' ) {
    $options .= ' disabled="disabled"';
}
?>
<tr>
    <th scope="row"><label for="<?=$meta['id'];?>"><?=$meta['title'];?></label></th>
    <td>
        <select name="<?=$meta['id'];?>" id="<?=$meta['id'];?>"<?=$options;?>>
        <?php foreach ( $meta['options']['values'] as $key => $value ) { ?>
            <option value="<?=$key;?>" <?php selected($meta['value'], $key);?>><?=$value;?></option>
        <?php } ?>
        </select>
        <?php if ($meta['description']) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
