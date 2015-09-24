<?php
if ( $field['options']['tag'] != '' ) {
    $tag = $field['options']['tag'];
} else {
    $tag = 'h2';
}
?>


<<?=$tag;?> id="<?=esc_attr($field['id']);?>"><?=$field['title'];?></<?=$tag;?>>
