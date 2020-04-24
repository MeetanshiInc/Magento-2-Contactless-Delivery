define(
    [
        'jquery',
        'ko',
        'Magento_Checkout/js/model/quote'
    ],
    function ($, ko, quote) {
        'use strict';
        return function (paymentMethod) {

            quote.paymentMethod(paymentMethod);
            var shippingMethod = quote.shippingMethod()['carrier_code'] + '_' + quote.shippingMethod()['method_code'];
            var payMethod = paymentMethod.method;

            var allowPayment = window.checkoutConfig.allow_payment;
            var allowShipping = window.checkoutConfig.allow_shipping;

            if (allowPayment && allowShipping) {

                allowPayment = allowPayment.split(',');
                allowShipping = allowShipping.split(',');

                var isPayment = allowPayment.indexOf(payMethod);
                var isShipping = allowShipping.indexOf(shippingMethod.toString());

                if (isPayment >= 0 && isShipping >= 0) {
                    $('#no-contact-div').show();
                } else {

                    $('#no-contact-div').hide();
                    $('#comment-code').val('');
                }
            } else {
                $('#no-contact-div').hide();
                $('#comment-code').val('');
            }
        }
    }
);
