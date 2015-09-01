/*jslint browser: true*/
/*global jQuery, console, ajaxurl, alert */

(function ($) {
	'use strict';

    // Tabs

    $('.js-md_yam_nav-tab').click(function (event) {

        event.preventDefault();

        if ($(this).hasClass('nav-tab-active')) {
            return;
        }

        var target = $(this).attr('href'),
            container = $(this).closest('.md_yam_fieldset').attr('id');

        $('#' + container + ' .js-md_yam_nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');

        $('#' + container + ' .md_yam_tab_content').css('display', 'none');
        $(target).css('display', 'block');

    });

    $('.js_md_yam_save_options').click(function (event) {

        event.preventDefault();

        var form_id = $(this).data('id'),
            data = $('#' + form_id).serialize();

        $.post(ajaxurl, data, function (response) {
            console.log(response);
            alert(response.message);
        }, 'json');

    });

}(jQuery));
