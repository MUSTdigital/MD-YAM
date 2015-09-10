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
    <th scope="row"><?=$meta['title'];?></th>
    <td>
        <fieldset>
            <legend class="screen-reader-text"><span><?=$meta['title'];?></span></legend>
            <?php foreach ( $meta['values'] as $key => $value ) { ?>
            <label title="<?=$key;?>"><input type="radio" name="<?=$meta['id'];?>" value="<?=$key;?>" <?php checked($meta['value'], $key);?> <?=$options;?>> <?=$value;?></label>
            <?php } ?>
        </fieldset>
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
