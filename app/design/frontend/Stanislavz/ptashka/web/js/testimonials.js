define ([
    'jquery',
    'mage/gallery/gallery'
], function ($, Gallery) {
    'use strict';

    $.widget("ptashka.carousel", {

        conf: {
            sliderPause: 3000
        },

        options: {
            "nav": "dots",
            "maxheight": "100",
            "loop": true
        },

        fullscreen: {},

        _create: function () {
            //var timer = this._autoSlide();
            var gallery = this._initGallery();
        },

        /**
         *
         * @returns {*} jQuery object with slides
         * @private
         */
        _getSlideList: function () {
            return this.element.children();
        },

        /**
         *
         * @returns {Array} HTML content of slides
         * @private
         */
        _getSlidesHtml: function () {
            var data = [],
                slideList = this._getSlideList();
            $.each(slideList, function (index, slide) {
                data.push({html: slide.outerHTML});
            });
            console.log(data);
            return data;
        },

        /**
         *
         * @returns {*} initiation of gallery
         * @private
         */
        _initGallery: function() {
            return Gallery({
                options: this.options,
                data: this._getSlidesHtml(),
                fullscreen: this.fullscreen
            }, this.element);
        },

        /**
         *  Begin Slider move
         * @private
         */
        _autoSlide: function () {
            var api = this._initGallery().settings.api;

            return setInterval(function () {
                api.next();
            }, this.conf.sliderPause);
        },

        _stopSlide: function (timer) {
            clearTimeout(timer);
        }
    });

    return $.ptashka.carousel;
});