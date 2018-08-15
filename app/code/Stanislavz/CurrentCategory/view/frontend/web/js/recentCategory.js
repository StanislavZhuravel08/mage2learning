define(
    [
        'jquery',
        'uiComponent',
        'ko'
    ], function ($, Component, ko) {
        'use strict';
        return Component.extend({
            initialize: function () {
                this._super();
                this.categories = ko.observableArray([]);
                this.getNewCategory();
            },

            getNewCategory: function () {
                let url = this.getUrl();

                $.get(url + 'recentCategory', function (response) {
                    this.categories.push(response);
                    console.log(this.categories());
                }.bind(this));
            },
            getUrl: function () {
                let url = window.location.href;
                url = url.split('/');
                url = [url[0], url[1], url[2]].join('/');
                return url + '/';
            }
        });
    }
);