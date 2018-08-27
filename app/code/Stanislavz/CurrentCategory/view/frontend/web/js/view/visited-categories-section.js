define([
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'jquery',
    'mage/mage',
    'mage/decorate'
], function (Component, customerData, $) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();
            this.visitedCategoriesSection = customerData.get('visited-categories-section');
            console.log(this.visitedCategoriesSection());
        },
    });
});