<?php
// Field attributes
$default_attributes = [
    'class' => isset($field['class']) ? $field['class'] : ''
];
$attributes = wp_parse_args( isset($field['attributes']) ? $field['attributes'] : [], $default_attributes );
$attrs = '';
foreach( $attributes as $key => $value ){
    $attrs .= ' ' . $key . '="' . esc_attr($value)  . '"';
}

if ( isset( $field['attributes']['multiple'] ) ) {
    $field['name'] = $field['name'] . '[]';
}

// Field options
$default_options = [
    'posts_per_page' => -1,
    'post_type' => 'page',
    'post_status' => 'any'
];
$options = wp_parse_args($field['options'], $default_options);
if ( !isset( $field['values'] ) ) {
    $field['values'] = get_posts($options);
}

?>
<tr>
    <th scope="row"><label for="<?=esc_attr($field['id']);?>"><?=$field['title'];?></label></th>
    <td>
        <select name="<?=esc_attr($field['name']);?>" id="<?=esc_attr($field['id']);?>"<?=$attrs;?>>
            <option value=""><?php _e('-- Select --', 'md-yam'); ?></option>
        <?php foreach ( $field['values'] as $post ) { ?>
            <option value="<?=$post->ID;?>" <?php selected($field['value'], $post->ID);?>><?=$post->post_title;?></option>
        <?php } ?>
        </select>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
