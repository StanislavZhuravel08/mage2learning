define([
    'jquery'
], function ($) {
    'use strict';

    $.widget("ptashka.scrollToTop", {
        /**
         * speed: int
         */
        options: {
            speed: 0 // not used for now. Should control animation speed
        },

        /**
         * @private
         */
        _create: function () {
            $(window).scroll(this.onScroll.bind(this));

            this.element.click(function () {
                $('html, body').scrollTop(0);
            });
        },

        onScroll: function () {
            var $header = $('.page-header');

            if ($(window).scrollTop() > $header.outerHeight()) {
                this.element.show();
            } else {
                this.element.hide();
            }
        }
    });

    return $.ptashka.scrollToTop;
});
