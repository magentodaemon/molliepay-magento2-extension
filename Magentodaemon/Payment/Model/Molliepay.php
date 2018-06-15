<?php

namespace Magentodaemon\Payment\Model;

use Magento\Payment\Model\Method\AbstractMethod;

class Molliepay extends \Magento\Payment\Model\Method\AbstractMethod
{
    protected $_code = 'molliepay';
    
    protected $_isOffline = true;
}
