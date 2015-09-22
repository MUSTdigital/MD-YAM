/*jslint browser: true, devel: true, indent: 4, es5: true*/
/*global jQuery, mdLocaleIconpicker */
/**
 * Fonticons Picker
 *
 * Based on: https://github.com/bradvin/dashicons-picker/
 */

(function ($) {
    'use strict';

    /**
     *
     * @returns {void}
     */
    $.fn.fonticonsPicker = function () {

        return this.each(function () {

            var button = $(this),
                icons = button.data('icons').split(','),
                prefix = button.data('prefix');

            function removePopup() {
                $('.fonticon-picker-container').remove();
                $(document).unbind('.fonticons-picker');
            }

            function createPopup(button) {

                var target = $(button.data('target')),
                    popup  = $('<div class="fonticon-picker-container">' +
                        '<div class="fonticon-picker-control" />' +
                        '<ul class="fonticon-picker-list" />' +
                        '</div>')
                        .css({
                            'top':  button.offset().top,
                            'left': button.offset().left
                        }),
                    list = popup.find('.fonticon-picker-list'),
                    control = popup.find('.fonticon-picker-control'),
                    i;

                for (i in icons) {
                    if (icons.hasOwnProperty(i)) {
                        list.append('<li data-icon="' + icons[i] + '"><a href="#" title="' + icons[i] + '"><span class="' + prefix + icons[i] + '"></span></a></li>');
                    }
                }

                $('a', list).click(function (event) {
                    event.preventDefault();
                    var title = $(this).attr('title');
                    target.val(title);
                    button.find('span').remove();
                    button.prepend('<span class="' + prefix + title + '"></span>');
                    removePopup();
                });

                control.html('<input type="text" class="" placeholder="' + mdLocaleIconpicker.search + '" >');

                popup.appendTo('body').show();

                $('input', control).on('keyup', function (event) {
                    var search = $(this).val();
                    if (search === '') {
                        $('li:lt(25)', list).show();
                    } else {
                        $('li', list).each(function () {
                            if ($(this).data('icon').toLowerCase().indexOf(search.toLowerCase()) !== -1) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    }
                });

                $(document).bind('mouseup.fonticons-picker', function (event) {
                    if (!popup.is(event.target) && popup.has(event.target).length === 0) {
                        removePopup();
                    }
                });
            }

            button.on('click.fonticonsPicker', function () {
                event.preventDefault();
                createPopup(button);
            });
        });
    };

}(jQuery));
