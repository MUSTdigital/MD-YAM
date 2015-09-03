<?php
$options = '';
if ( $meta['options']['required'] != '' ) {
    $options .= ' required="required"';
}
if ( $meta['options']['disabled'] != '' ) {
    $options .= ' disabled="disabled"';
}

if ( empty( $meta['values'] ) ) {
    $meta['values'] = get_posts([
        'posts_per_page' => -1,
        'post_type' => $meta['options']['post_type'],
        'post_status' => 'any',
    ]);
}

?>
<tr>
    <th scope="row"><label for="<?=$meta['id'];?>"><?=$meta['title'];?></label></th>
    <td>
        <select name="<?=$meta['id'];?>" id="<?=$meta['id'];?>"<?=$options;?>>
        <?php foreach ( $meta['values'] as $post ) { ?>
            <option value="<?=$post->ID;?>" <?php selected($meta['value'], $post->ID);?>><?=$post->post_title;?></option>
        <?php } ?>
        </select>
        <?php if ($meta['description']) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
