<?php
$options = '';
if ( isset($field['options']['required']) ) {
    $options .= ' required="required"';
}
if ( isset($field['options']['disabled']) ) {
    $options .= ' disabled="disabled"';
}

if ( isset($field['options']['post_type']) ) {
    $post_type = $field['options']['post_type'];
} else {
    $post_type = 'page';
}

if ( !isset( $field['values'] ) ) {
    $field['values'] = get_posts([
        'posts_per_page' => -1,
        'post_type' => $post_type,
        'post_status' => 'any',
    ]);
}

?>
<tr>
    <th scope="row"><label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label></th>
    <td>
        <select name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>"<?=$options;?>>
            <option value=""><?php _e('-- Select --', 'md-yam'); ?></option>
        <?php foreach ( $field['values'] as $post ) { ?>
            <option value="<?=$post->ID;?>" <?php selected($field['value'], $post->ID);?>><?=$post->post_title;?></option>
        <?php } ?>
        </select>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
