define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'molliepay',
                component: 'Magentodaemon_Payment/js/view/payment/method-renderer/molliepay'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);