define([
    'Magento_Ui/js/form/element/abstract',
    'jquery'
], function(Abstract, $) {
    'use strict';

    return Abstract.extend({
        initialize: function () {
            this._super();

            return this;
        },

        /**
         * Handle radio click, return true to check te radio
         */
        click: function(data, event) {
            this.change(event.target.value, event.target);
            return true;
        },

        /**
         * Change value of radio
         */
        change: function(value) {
            value = parseInt(value);
            var privateBusinessSelector = $('[id*='+ this.uid +'][name=private_business]:checked');
            if (value !== parseInt(privateBusinessSelector.val())) {
                value = privateBusinessSelector.val();
            }
            var inputElement = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
            var fieldNames = ".field[name='shippingAddress.vat_id'], .field[name='shippingAddress.company']";
            var fieldNamesBilling = ".field[name='billingAddressshared.vat_id'], .field[name='billingAddressshared.company']";

            var $fields = $(fieldNames);
            var $fieldsBilling = $(fieldNamesBilling);
            if (inputElement) {
                $fields = $(inputElement).closest('form').find(fieldNames);
            }

            if (value === 0) {
                $fields.css("display", "none");
                $fields.removeClass("_required");
                $fields.find('input').prop("required", null);
                $fields.each(function(e){
                    $(this).find("input").val("").trigger("change");
                });
            } else if (value === 1) {
                $fields.css("display", "inline-block");
                $fields.addClass("_required");
                $fields.find('input').prop("required", true);
            } else if (value === undefined) {
                $fields.css("display", "none");
                $fields.removeClass("_required");
                $fields.find('input').prop("required", null);
            }

            $fieldsBilling.removeClass("_required");
            $fieldsBilling.find('input').prop("required", null);
        }
    });
});
