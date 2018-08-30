define(
    [
        'jquery',
        'uiComponent',
        'uiRegistry',
        'Magento_Customer/js/customer-data',
        'ko'
    ], function ($, Component, Registry, customerData, ko) {
        'use strict';

        return Component.extend({

            categories   : [],
            dataFieldName: 'visited-categories',

            initialize: function (currentCategoryId, limit) {
                this._super();
                this.categories = ko.observableArray([]);
                this.customerData = customerData;
                this.getNewCategory();
            },

            getNewCategory: function () {
                let baseUrl = this.getUrlBase();
                let sendData = this.getCopyCategories();
                $.get(baseUrl + 'visitedCategories', { "sendData" : sendData }, function (response) {
                    this.setNewCategory({ categoryId: this.categoryId }, this.limit);
                    console.log(this.customerData.get(this.dataFieldName)());
                }.bind(this));
            },

            /**
             * @returns {string}
             */
            getUrlBase: function () {
                let url = window.location.href;
                url = url.split('/');
                url = [url[0], url[1], url[2]].join('/');
                return url + '/';
            },

            /**
             * @returns {*}
             */
            getCopyCategories: function () {
                if (!this.customerData.get(this.dataFieldName)().length) {
                    this.customerData.set(this.dataFieldName, this.categories);
                }

                return this.customerData.get(this.dataFieldName)();
            },

            /**
             * Set new category to store
             *
             * @param obj
             * @param limit
             */
            setNewCategory: function (obj, limit) {
                let data = this.addCategory(obj, limit);
                this.customerData.set(this.dataFieldName, data);
            },

            /**
             * Checks is the category id unique
             *
             * @param obj
             * @returns {*}
             */
            removeDistinct: function (obj) {
                let copyCategories = this.getCopyCategories().slice();
                for (let i = 0; i < copyCategories.length; i++) {
                    if (copyCategories[i].categoryId === obj.categoryId) {
                        copyCategories.splice(i, 1);
                    }
                }
                return copyCategories;
            },

            /**
             *
             * @param obj
             * @param limit
             * @returns {*}
             */
            addCategory: function (obj, limit) {
                let data = this.removeDistinct(obj);
                if (data.length >= limit) {
                    data.shift();
                }
                data.push(obj);
                return data;
            }
        });
    }
);