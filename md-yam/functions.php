<?php

function md_yam_mf( $options, $fields ) {
    global $md_yam_object;
    $md_yam_object->new_fieldset( $options, $fields );
}

function _md_yam_fix_id( $var ) {
    $replace = [
        '[' => '_',
        ']' => '_'
    ];
    return strtr( $var, $replace );
}
