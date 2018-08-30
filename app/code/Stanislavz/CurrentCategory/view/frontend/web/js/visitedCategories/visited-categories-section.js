define([
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'jquery',
    'mage/mage',
    'mage/decorate'
], function (Component, customerData, $) {
    'use strict';

    return Component.extend({

        addActionRoute: 'current_category/add',

        /** @inheritdoc */
        initialize: function () {
            this._super();
            this.visitedCategoriesSection = customerData.get('visited-categories-section');
            this.tryTest();
        },

        /**
         * @returns {string}
         */
        getBaseUrl: function () {
            return window.BASE_URL;
        },

        tryTest: function() {
            let baseUrl = this.getBaseUrl();
            $.get(baseUrl + this.addActionRoute, { "sendData" : 'request' }, function (response) {
                console.log(response);
            }.bind(this));
        }
    });
});