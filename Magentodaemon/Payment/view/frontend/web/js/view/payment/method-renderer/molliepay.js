define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';

        return Component.extend({
            defaults: {
				redirectAfterPlaceOrder: false,
                template: 'Magentodaemon_Payment/payment/molliepay'
            },
			afterPlaceOrder : function ()
			{
				// Call this after order place
				
				console.log("Order has been placed successfullly");
				window.location.replace(window.checkoutConfig.payment.molliepay.redirecturl);
			}	
        });
    }
);
