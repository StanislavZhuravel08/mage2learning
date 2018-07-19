define([
    'jquery'
], function ($) {
    'use strict';

    $.widget("custom.scrollToTop", {

        /**
         * speed: int
         *
         */
        options: {
            speed: 0
        },

        /**
         *
         * @private
         */
        _create: function () {
            var btn = this.element,
                options = this.options;

            $(window).scroll(function () {
                var topNav = $('header .logo');
                var height = topNav.offset().top + topNav.outerHeight();


                if ($(this).scrollTop() > height) {
                    btn.show();
                } else {
                    btn.hide();
                }
            });

            btn.click(function () {

                $('html, body').scrollTop(0);

            });

        }
    });
});
