<?php
//    get_post_meta ( int $post_id, string $key = '', bool $single = false )\;


    $fields = array_map(function ($field) {

        switch ($this->meta_type) {
            case 'postmeta':
                $field['_function'] = 'get_post_meta( ';

                if ($this->meta_group) {
                    $field['_function'] .= '$post_id, \'' . $this->meta_group . '\', true';
                } else {
                    $field['_function'] .= '$post_id, \'' . $field['id'] . '\', true';
                }

                if ($this->meta_group) {
                    $field['_function'] .= ' )[\'' . $field['id'] . '\'];';
                } else {
                    $field['_function'] .= ' );';
                }

                if ($this->meta_post_id) {
                    $field['_function'] = str_replace('$post_id', $this->meta_post_id, $field['_function']);
                }
                break;

            case 'dashboard':
            case 'menu_page':
            case 'submenu_page':
                $field['_function'] = 'get_option( ';

                if ($this->meta_group) {
                    $field['_function'] .= '\'' . $this->meta_group . '\'';
                } else {
                    $field['_function'] .= '\'' . $field['id'] . '\'';
                }

                if ($this->meta_group) {
                    $field['_function'] .= ' )[\'' . $field['id'] . '\'];';
                } else {
                    $field['_function'] .= ' );';
                }
                break;
        }

        return $field;

    }, $this->only_fields);

    $count = count($fields);
    $field = $fields[0];

    array_shift($fields);

?>
<table class="widefat md_yam_admintable">
    <thead>
        <tr>
            <th>
                <?php _e( 'Fieldset', 'md-yam' ); ?>
            </th>
            <th>
                <?php _e( 'Field title', 'md-yam' ); ?>
            </th>
            <th>
                <?php _e( 'Field ID', 'md-yam' ); ?>
            </th>
            <th>
                <?php _e( 'Field type', 'md-yam' ); ?>
            </th>
            <th>
                <?php _e( 'Code', 'md-yam' ); ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="<?php echo $count;?>">
                <p><?php _e( 'Title', 'md-yam' );?>: <strong><?php echo $this->meta_title;?></strong></p>
                <p><?php _e( 'ID', 'md-yam' );?>: <strong><?php echo $this->meta_id;?></strong></p>
                <p><?php _e( 'Type', 'md-yam' );?>: <strong><?php echo apply_filters( '_md_yam_loc', $this->meta_type );?></strong></p>

                <?php if ( $this->meta_group ) { ?>
                <p><?php _e( 'Group', 'md-yam' );?>: <strong><?php echo $this->meta_group;?></strong></p>
                <?php } ?>

                <?php if ( $this->meta_post_type ) { ?>
                <p><?php _e( 'Post type', 'md-yam' );?>: <strong><?php echo $this->meta_post_type;?></strong></p>
                <?php } ?>

                <?php if ( $this->meta_post_id ) { ?>
                <p><?php _e( 'Post ID', 'md-yam' );?>: <strong><?php echo $this->meta_post_id;?></strong></p>
                <?php } ?>

            </td>
            <td>
                <p><?php echo $field['title'];?></p>
            </td>
            <td>
                <p><?php echo $field['id'];?></p>
            </td>
            <td>
                <p><?php echo apply_filters( '_md_yam_loc', $field['type'] );?></p>
            </td>
            <td>
                <input type="text" class="code" value="<?php echo $field['_function'];?>">
            </td>
        </tr>

<?php $i = 1; foreach($fields as $field){ ?>
        <tr<?php if ($i & 1) { echo ' class="alternate"'; } ?>>
            <td>
                <p><?php echo $field['title'];?></p>
            </td>
            <td>
                <p><?php echo $field['id'];?></p>
            </td>
            <td>
                <p><?php echo apply_filters( '_md_yam_loc', $field['type'] );?></p>
            </td>
            <td>
                <input type="text" class="code" value="<?php echo $field['_function'];?>">
            </td>
        </tr>
<?php $i++; } ?>
    </tbody>
</table>
<br>
