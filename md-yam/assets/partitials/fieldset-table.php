<?php
//md_get_field( $fieldset_id, $field_name, $object_id = null )
    $fields = array_map(function ($field) {

        $field['_function'] = 'md_get_field( \'' . $this->options['id'] . '\', \'' . $field['name'] . '\'';

        switch ($this->options['type']) {
            case 'postmeta':
            case 'usermeta':
            case 'termmeta':
                $type = str_replace( 'meta', '', $this->options['type'] );

                $field['_function'] .= ', $' . $type . '_id';

                if ($this->options['post_id']) {
                    $field['_function'] = str_replace('$post_id', $this->options['post_id'], $field['_function']);
                } elseif ($this->options['user_id']) {
                    $field['_function'] = str_replace('$user_id', $this->options['user_id'], $field['_function']);
                }
                break;

        }

        $field['_function'] .= ' )';

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
