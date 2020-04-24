/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/place-order',
    'Magento_CheckoutAgreements/js/model/agreements-assigner'
], function ($,quote, urlBuilder, customer, placeOrderService,agreementsAssigner) {
    'use strict';

    return function (paymentData, messageContainer) {
        var serviceUrl, payload;
        agreementsAssigner(paymentData);

        var commnt =$('[name="comment-code"]').val();

        if($('#is-no-contact').prop("checked") && commnt==''){
            commnt = 'Leave At Front Door'
        }

        payload = {
            cartId: quote.getQuoteId(),
            billingAddress: quote.billingAddress(),
            paymentMethod: paymentData,
            comments: commnt
        };

        if (customer.isLoggedIn()) {
            serviceUrl = urlBuilder.createUrl('/carts/mine/payment-information', {});
        } else {
            serviceUrl = urlBuilder.createUrl('/guest-carts/:quoteId/payment-information', {
                quoteId: quote.getQuoteId()
            });
            payload.email = quote.guestEmail;
        }

        return placeOrderService(serviceUrl, payload, messageContainer);
    };
});