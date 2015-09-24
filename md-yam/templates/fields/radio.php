<?php
$options = '';
if ( isset($field['options']['required']) ) {
    $options .= ' required="required"';
}
if ( isset($field['options']['disabled']) ) {
    $options .= ' disabled="disabled"';
}
?>
<tr>
    <th scope="row"><?=$field['title'];?></th>
    <td>
        <fieldset>
            <legend class="screen-reader-text"><span><?=$field['title'];?></span></legend>
            <?php foreach ( $field['values'] as $key => $value ) { ?>
            <label title="<?=esc_attr($key);?>"><input type="radio" name="<?=esc_attr($field['name']);?>" value="<?=esc_attr($key);?>" <?php checked($field['value'], $key);?> <?=$options;?>> <?=$value;?></label>
            <?php } ?>
        </fieldset>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
