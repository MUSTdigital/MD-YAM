<?php
// Editor sizes
$style = '';
if ( isset($meta['options']['width']) ) {
    $style .= 'width: ' . $meta['options']['width'] . '; ';
}
if ( isset($meta['options']['height']) ) {
    $style .= 'height: ' . $meta['options']['height'] . '; ';
}

// Editor options
$language = '';
$theme = '';
if ( isset($meta['options']['language']) ) {
    $language = $meta['options']['language'];
}
if ( isset($meta['options']['theme']) ) {
    $theme = $meta['options']['theme'];
}

// Container classes.
if ( isset($meta['options']['class']) ) {
    $class = $meta['options']['class'];
}
?>
<tr>
    <th scope="row"><?=$meta['title'];?></th>
    <td>
        <div class="md-codeeditor-container <?=$class;?>" style="<?=$style;?>">
            <input type="hidden" name="<?=$meta['id'];?>" id="<?=$meta['id'];?>-input" value="<?=$meta['value'];?>">
            <div class="md-codeeditor"
                 id="<?=$meta['id'];?>"
                 data-mdyam="code-editor"
                 data-language="<?=$language;?>"
                 data-theme="<?=$theme;?>"
                 data-input="#<?=$meta['id'];?>-input"><?=$meta['value'];?></div>
        </div>
        <?php if ( isset($meta['description']) ) { ?><p class="description"><?=$meta['description'];?></p><?php } ?>
    </td>
</tr>
