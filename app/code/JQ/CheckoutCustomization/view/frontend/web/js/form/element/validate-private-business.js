define([
    'jquery',
    'Magento_Ui/js/lib/validation/validator',
    'Magento_Ui/js/form/element/abstract'
], function($, validator, Element) {
    'use strict';

    return Element.extend({
        initialize: function() {

            validator.addRule(
                'validate-private-business',
                function(value) {

                    var selector = '[name=private_business]:checked';

                    if ($('li#payment.checkout-payment-method').is(":visible")) {
                        selector = '.payment-method._active ' + selector;
                    }

                    if ($(selector).val() == 1 && value.length == 0) {
                        return false;
                    } else {
                        return true;
                    }
                },
                $.mage.__('This is a required field.')
            );

            this._super();
        }
    });
});