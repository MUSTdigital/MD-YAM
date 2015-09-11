/*jslint browser: true, devel: true, indent: 4, es5: true*/
/*global jQuery, wp */
/**
 * Fonticons Picker
 */

(function ($) {
    'use strict';

    $.fn.filePicker = function (options) {

        var settings = $.extend({
            buttonText: 'Use this media',
            frameTitle: 'Select or Upload Media Of Your Chosen Persuasion',
            image: true
        }, options);

        return this.each(function () {

            var button = $(this),
                target = $(button.data('target')),
                imgContainer,
                valueType = button.data('value-type'),
                frame;

//            if (settings.image) {
                imgContainer = $(button.data('image-container'));
//            }

            function openDialog() {
                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: settings.frameTitle,
                    button: {
                        text: settings.buttonText
                    },
                    multiple: false
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();

//                    if (settings.image) {
                        imgContainer.empty().html('<img src="' + attachment.sizes.thumbnail.url + '" alt="" style="max-width:100%;">');
//                    }
                    target.val(attachment[valueType]);
                });

                frame.open();
            }

            button.on('click.filePicker', function () {
                event.preventDefault();
                openDialog();
            });
        });
    };

}(jQuery));
