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
    <th scope="row">
        <label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label>
    </th>
    <td>
        <input name="<?=esc_attr($field['name']);?>" type="checkbox" value="1" id="<?=esc_attr($field['id']);?>" <?php checked($field['value'], 1);?> <?=$options;?> >
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
