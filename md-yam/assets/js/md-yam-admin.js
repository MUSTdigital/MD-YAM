/*jslint browser: true, devel: true*/
/*global jQuery, ajaxurl, ace */

(function ($) {
	'use strict';

    $(document).ready(function ($) {

        if (typeof $().wpColorPicker === "function") {
            $('[data-mdyam="wpcolorpicker"]').wpColorPicker();
        }

        if (typeof $().fonticonsPicker === "function") {
            $('[data-mdyam="fonticonspicker"]').fonticonsPicker();
        }

        if (typeof $().filePicker === "function") {
            $('[data-mdyam="imagepicker"]').filePicker();
            $('[data-mdyam="filepicker"]').filePicker({
                image: false
            });
        }

        if (typeof ace === "object") {
            $('[data-mdyam="code-editor"]').each(function () {
                var editor   = ace.edit(this),
                    theme    = $(this).data('theme'),
                    language = $(this).data('language'),
                    input    = $($(this).data('input'));

                if (theme !== '') {
                    editor.setTheme('ace/theme/' + theme);
                }
                if (language !== '') {
                    editor.getSession().setMode('ace/mode/' + language);
                }

                editor.getSession().on('change', function (event) {
                    input.val(editor.getValue());
                });
            });
        }
    });

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
