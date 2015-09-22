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
    <th scope="row"><label for="<?=$meta['id'];?>"><?=$meta['title'];?></label></th>
    <td>
        <select name="<?=$meta['id'];?>" id="<?=$meta['id'];?>"<?=$options;?>>
            <option value=""><?php _e('-- Select --', 'md-yam'); ?></option>
        <?php foreach ( $meta['values'] as $key => $value ) { ?>
            <option value="<?=$key;?>" <?php selected($meta['value'], $key);?>><?=$value;?></option>
        <?php } ?>
        </select>
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
