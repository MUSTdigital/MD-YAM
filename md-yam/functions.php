<?php

function md_yam_mf($options, $fields) {
    global $md_yam_object;
    $md_yam_object->get_functions()->create_fieldset($options, $fields);
}
