define(
    [
        'jquery',
        'uiComponent',
        'Magento_Customer/js/customer-data',
        'ko'
    ], function ($, Component, customerData, ko) {
        'use strict';
        return Component.extend({
            initialize: function () {
                this._super();
                let dataObject = customerData.get('visited_categories');
                let data = dataObject();
                customerData.reload(['visited_categories']);
                this.categories = [];
                this.getNewCategory();
                console.log(data);
            },

            getNewCategory: function () {
                let url = this.getUrl();

                $.get(url + 'recentCategory', function (response) {
                    this.categories.push(this.categoryId);
                    console.log(this.categories);
                }.bind(this));
            },
            getUrl: function () {
                let url = window.location.href;
                url = url.split('/');
                url = [url[0], url[1], url[2]].join('/');
                return url + '/';
            },

        });
    }
);