<?php
// Field options
$options = '';
if ( isset($meta['options']['placeholder']) ) {
    $options .= ' placeholder="' . $meta['options']['placeholder'] . '"';
}
if ( isset($meta['options']['required']) ) {
    $options .= ' required="required"';
}

// Field classes
if ( isset($meta['options']['class']) ) {
    $class = $meta['options']['class'];
} else {
    $class = 'regular-text';
}

// Button classes
if ( isset($meta['options']['button_class']) ) {
    $button_class = $meta['options']['button_class'];
} else {
    $button_class = 'button button-secondary md-filepicker-button';
}

// Value type
if ( isset($meta['options']['value_type']) ) {
    $value_type = $meta['options']['value_type'];
} else {
    $value_type = 'url';
}
?>
<tr>
    <th scope="row">
        <?=$meta['title'];?>
    </th>
    <td>
        <input type="text" value="<?=$meta['value'];?>" name="<?=$meta['id'];?>" id="<?=$meta['id'];?>" class="<?=$class;?>"<?=$options;?>><br>
        <button value="<?=$meta['value'];?>"
                class="<?=$button_class;?>"
                data-value-type="<?=$value_type;?>"
                data-target="#<?=$meta['id'];?>"
                data-mdyam="filepicker">
            <?php _e('Select file', 'md-yam'); ?>
        </button>
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
