<?php
//    get_post_meta ( int $post_id, string $key = '', bool $single = false )\;


    $fields = array_map(function ($field) {

        switch ($this->options['type']) {
            case 'postmeta':
            case 'usermeta':
                $type = $this->options['type'] === 'postmeta' ? 'post' : 'user';

                $field['_function'] = 'get_' . $type . '_meta( ';

                if ($this->options['group']) {
                    $field['_function'] .= '$' . $type . '_id, \'' . $this->options['group'] . '\', true';
                } else {
                    $field['_function'] .= '$' . $type . '_id, \'' . $field['name'] . '\', true';
                }

                if ($this->options['group']) {
                    $field['_function'] .= ' )[\'' . $field['name'] . '\'];';
                } else {
                    $field['_function'] .= ' );';
                }

                if ($this->options['post_id']) {
                    $field['_function'] = str_replace('$post_id', $this->options['post_id'], $field['_function']);
                } elseif ($this->options['user_id']) {
                    $field['_function'] = str_replace('$user_id', $this->options['user_id'], $field['_function']);
                }
                break;

            case 'dashboard':
            case 'menu_page':
            case 'submenu_page':
                $field['_function'] = 'get_option( ';

                if ($this->options['group']) {
                    $field['_function'] .= '\'' . $this->options['group'] . '\'';
                } else {
                    $field['_function'] .= '\'' . $field['name'] . '\'';
                }

                if ($this->options['group']) {
                    $field['_function'] .= ' )[\'' . $field['name'] . '\'];';
                } else {
                    $field['_function'] .= ' );';
                }
                break;
        }

        return $field;

    }, $this->fields);

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
                <p><?php _e( 'Title', 'md-yam' );?>: <strong><?php echo $this->options['title'];?></strong></p>
                <p><?php _e( 'ID', 'md-yam' );?>: <strong><?php echo $this->options['id'];?></strong></p>
                <p><?php _e( 'Type', 'md-yam' );?>: <strong><?php echo apply_filters( '_md_yam_loc', $this->options['type'] );?></strong></p>

                <?php if ( $this->options['group'] ) { ?>
                <p><?php _e( 'Group', 'md-yam' );?>: <strong><?php echo $this->options['group'];?></strong></p>
                <?php } ?>

                <?php if ( $this->options['post_type'] ) { ?>
                <p><?php _e( 'Post type', 'md-yam' );?>: <strong><?php echo $this->options['post_type'];?></strong></p>
                <?php } ?>

                <?php if ( $this->options['post_id'] ) { ?>
                <p><?php _e( 'Post ID', 'md-yam' );?>: <strong><?php echo $this->options['post_id'];?></strong></p>
                <?php } ?>

                <?php if ( $this->options['user_id'] ) { ?>
                <p><?php _e( 'User ID', 'md-yam' );?>: <strong><?php echo $this->options['user_id'];?></strong></p>
                <?php } ?>

            </td>
            <td>
                <p><?php echo $field['title'];?></p>
            </td>
            <td>
                <p><?php echo $field['name'];?></p>
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
                <p><?php echo $field['name'];?></p>
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
