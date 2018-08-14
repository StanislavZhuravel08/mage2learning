define([
        'jquery',
        'uiComponent',
        'ko'
    ], function ($, Component, ko) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Stanislavz_CurrentCategory/knockout-test'
            },
            initialize: function () {
                this._super();
            }
        });
    }
);