<?php

/**
 * Adds new fieldset to the global $md_yam_all_fieldsets variable.
 * @param  array  $options  Array of options
 * @param  array  $fields   Array of fields
 * @since  0.5.0
 */
function md_yam_mf( $options, $fields ) {
    global $md_yam_all_fieldsets;

    $defaults = [
        // Common
        'title'     => false,
        'id'        => false,
        'group'     => false,
        'group_val' => false,
        'thin'      => false,
        'type'      => 'postmeta',

        // Postmeta
        'post_type' => null,
        'post_id'   => false,
        'context'   => 'advanced',

        // Usermeta
        'user_id'   => false,

        // Termmeta
        'taxonomy'  => 'category',

        // Options page
        'parent_slug' => 'options-general.php',
        'menu_title'  => false,
        'capability'  => 'manage_options',
        'icon_url'    => '',
        'position'    => null

    ];

    $options = wp_parse_args($options, $defaults);

    if ( !$options['title'] ) {
        trigger_error( __( 'Title of the fieldset is not defined.', 'md-yam' ) );
    }

    if ( !$options['id'] ) {
        trigger_error( __( 'ID of the fieldset is not defined.', 'md-yam' ) );
    }

    // Setup other defaults if needed.
    if ( $options['group'] === true ) {
        $options['group'] = $options['id'];
    }
    if ( !$options['menu_title'] ) {
        $options['menu_title'] = $options['title'];
    }


    $md_yam_all_fieldsets[$options['id']] = [
        'options' => $options,
        'fields'  => $fields
    ];
}

/**
 * Retrieves field value.
 * @param   string  $fieldset_id Fieldset ID
 * @param   string  $field_name  Field name
 * @param   int     $object_id   Object ID.
 * @return  mixed   Returns the value of the field or false if there is no value nor default.
 * @since   0.7.0
 */
function md_get_field( $fieldset_id, $field_name, $object_id = null ) {
    global $md_yam_all_fieldsets;

    // Find fieldset.
    $fieldset = $md_yam_all_fieldsets[$fieldset_id];
    if ( !$fieldset ) {
        return false;
    }

    // Find field.
    $field_id = _md_recursive_array_search( $field_name, $fieldset['fields']);
    if ( $field_id !== false ) {
        $field = $fieldset['fields'][$field_id];
    } else {
        return false;
    }

    // Setup meta name.
    if ( $fieldset['options']['group'] ) {
        $meta_name = $fieldset['options']['group'];
    } else {
        $meta_name = $field_name;
    }

    // Fetch value.
    switch ( $type = $fieldset['options']['type'] ) {
        case 'postmeta':
            $value = get_post_meta( $object_id, $meta_name, true );
            break;
        case 'usermeta':
            $value = get_user_meta( $object_id, $meta_name, true );
            break;

        case 'termmeta':
            $value = get_term_meta( $object_id, $meta_name, true );
            break;

        case 'dashboard':
        case 'menu_page':
        case 'submenu_page':
            $value = get_option( $meta_name );
            break;
    }

    // Check group.
    if ( $value ) {

        if ( $fieldset['options']['group'] ) {
            $value = maybe_unserialize( $value )[$field_name];
        }

    }

    // Check default.
    if ( !$value ) {

        if ( $field['default'] ) {
            $value = $field['default'];
        } else {
            return false;
        }

    }

    return $value;

}

/**
 * Replaces square brackets with underscores.
 * @param  string  $var
 * @return string
 */
function _md_yam_fix_id( $var ) {
    $replace = [
        '[' => '_',
        ']' => '_'
    ];
    return strtr( $var, $replace );
}

if ( !function_exists( '_md_recursive_array_search' ) ) :
/**
 * Recursivly searches the array for a given value and returns the corresponding key if successful
 * @param  string $needle   The searched value.
 * @param  array  $haystack The array
 * @return mixed  Returns the key for needle if it is found in the array, false otherwise
 */
function _md_recursive_array_search( $needle, $haystack ) {
    foreach( $haystack as $key => $value ) {
        $current_key = $key;
        if ( $needle === $value OR ( is_array( $value ) && _md_recursive_array_search( $needle, $value ) !== false ) ) {
            return $current_key;
        }
    }
    return false;
}
endif;


if ( !function_exists( '_md_is_assoc' ) ) :
/**
 * Checks if the provided array is associative.
 * @param  array   $arr  Array to check
 * @return boolean       True if array is associative, false if array is sequential.
 */
function _md_is_assoc( $arr ) {
    return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
}
endif;
