<tr>
    <th scope="row"><label for="<?=$meta['id'];?>'"><?=$meta['title'];?></label></th>
    <td>
        <?php wp_editor( $meta['value'], $meta['id'], $meta['options']['tinymce'] ); ?>
        <?php if ($meta['description']) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
