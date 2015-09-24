<?php
$defaults = [
    'textarea_name' => $field['name']
];

if ( isset($field['options']['tinymce']) ) {
    $options = $field['options']['tinymce'];
} else {
    $options = [];
}

$options = wp_parse_args($options, $defaults);
var_dump($options);
?>
<tr>
    <th scope="row"><label for="<?=esc_attr($field['id']);?>'"><?=$field['title'];?></label></th>
    <td>
        <?php wp_editor( $field['value'], $field['id'], $options ); ?>
        <?php if ( isset($field['description']) ) { ?><p class="description"><?=$field['description'];?></p><?php } ?>
    </td>
</tr>
