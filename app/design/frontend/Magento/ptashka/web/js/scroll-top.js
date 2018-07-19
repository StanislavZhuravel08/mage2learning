define([
    'jquery',
    'scroll-top-widget'
], function ($) {
    'use strict';

    /**
     * conf: {}
     * el: $(element)
     *
     * @param conf
     * @param el
     */
    return function (conf, el) {
        $(el).scrollToTop({
            speed: 500
        });
    };
});
