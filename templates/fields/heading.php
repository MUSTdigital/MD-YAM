<?php
if ( $meta['options']['tag'] != '' ) {
    $tag = $meta['options']['tag'];
} else {
    $tag = 'h2';
}
?>


<<?=$tag;?> id="<?=$meta['id'];?>"><?=$meta['title'];?></<?=$tag;?>>
