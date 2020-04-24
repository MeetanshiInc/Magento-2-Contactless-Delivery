define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';
    var canVisibleBlock = window.checkoutConfig.show_comment_block;
    var nocontact_label = window.checkoutConfig.nocontact_label;
    var nocontact_description = window.checkoutConfig.nocontact_description;

    return Component.extend({
        defaults: {
            template: 'Meetanshi_NoContact/checkout/shipping/additional-block'
        },
        canVisibleBlock: ko.observable(canVisibleBlock),
        getNoContactLabel: ko.observable(nocontact_label),
        getNoContactDescription: ko.observable(nocontact_description),
        noContactCheck: function () {

            if($('#is-no-contact').prop("checked") ){
                $('.field.commnet-field').show();

            }else{
                $('.field.commnet-field').hide();
            }

            return true;
        }
    });
});
