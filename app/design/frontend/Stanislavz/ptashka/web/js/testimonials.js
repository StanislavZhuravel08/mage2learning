define ([
    'jquery',
    'mage/gallery/gallery'
], function ($, Gallery) {
    'use strict';

    $.widget("ptashka.carousel", {

        conf: {
            sliderPause: 5000,
            breakpoint: 768
        },

        options: {
            "nav"               : "dots",
            "maxheight"         : "100",
            "transitionduration": 1000,
            "loop"              : true
        },

        fullscreen: {},

        breakpoints: {},

        _create: function () {
            var timer = this._autoSlide();
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
        },
        
        // _checkPageWidth: function () {
        //     var fotoramaActive = $('.fotorama__stage__frame.fotorama__active'),
        //         windowWidth = $(window).width(),
        //         fotoramaWidth = fotoramaActive.width(),
        //         nextSlide = fotoramaActive.next(),
        //         prevSlide = fotoramaActive.prev(),
        //         fotoramaLeft = fotoramaActive.position().left;
        //     console.log(nextSlide);
        //
        //     if (windowWidth >= this.conf.breakpoint ) {
        //         fotoramaActive.width(fotoramaWidth/2);
        //         nextSlide.width(fotoramaActive.width());
        //         prevSlide.width(fotoramaActive.width());
        //     }
        // }
    });

    return $.ptashka.carousel;
});