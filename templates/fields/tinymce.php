<?php
if ( isset($meta['options']['tinymce']) ) {
    $options = $meta['options']['tinymce'];
} else {
    $options = [];
}
?>
<tr>
    <th scope="row"><label for="<?=$meta['id'];?>'"><?=$meta['title'];?></label></th>
    <td>
        <?php wp_editor( htmlspecialchars_decode($meta['value']), $meta['id'], $options ); ?>
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
