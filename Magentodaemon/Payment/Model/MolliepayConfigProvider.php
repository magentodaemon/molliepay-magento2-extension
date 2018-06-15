<?php

namespace Magentodaemon\Payment\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Escaper;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Framework\Url;

class MolliepayConfigProvider implements ConfigProviderInterface
{
    /**
     * @var string[]
     */
    protected $methodCode = 'molliepay';

    /**
     * @var Checkmo
     */
    protected $method;

    /**
     * @var Escaper
     */
    protected $escaper;
    
    
    protected $urlbuilder;

    /**
     * @param PaymentHelper $paymentHelper
     * @param Escaper $escaper
     */
    public function __construct(
        PaymentHelper $paymentHelper,
        Escaper $escaper,
        Url $urlbuilder
    ) {
        $this->escaper = $escaper;
        $this->method = $paymentHelper->getMethodInstance($this->methodCode);
        $this->urlbuilder =$urlbuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'molliepay' => [
                    'redirecturl' => $this->urlbuilder->getUrl('molliepay/process/payment/', ['_secure' => true]),
                ],
            ],
        ] : [];
    }
}
