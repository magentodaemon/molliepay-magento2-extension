<?php
 
namespace Magentodaemon\Payment\Controller\Process;
 
use Magento\Framework\App\Action\Context;

 
class Payment extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
	protected $_storeConfig;
	protected $_urlBuilder;
 
    public function __construct(
		Context $context, 
		\Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\App\Config\ScopeConfigInterface $storeConfig,
		\Magento\Framework\UrlInterface $urlBuilder	
	)
    {
		$this->_urlBuilder = $urlBuilder;	
        $this->_resultPageFactory = $resultPageFactory;
        $this->_storeConfig=$storeConfig;
		
		parent::__construct($context);
    }
 
    public function execute()
    {
       $session = $this->getOnepage()->getCheckout();
	   $order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($session->getLastOrderId());
	   $apikey = $this->_storeConfig->getValue(
					'payment/molliepay/api',
					\Magento\Store\Model\ScopeInterface::SCOPE_STORE
				);
				
	   $apiurl = $this->_storeConfig->getValue(
					'payment/molliepay/apiurl',
					\Magento\Store\Model\ScopeInterface::SCOPE_STORE
				);	

		$crl = curl_init();

		$data=array(
			"amount" => number_format($order->getGrandTotal(),2,'.',''),
			"description" => "payment for order",
			"redirectUrl" => $this->_urlBuilder->getUrl("checkout/onepage/success"),
			"metadata[order_id]" => $order->getIncrementId(),
		);
		
		curl_setopt($crl, CURLOPT_URL,trim($apiurl));
		$headr = array();
		$headr[] = 'Authorization: Bearer '.trim($apikey);

		curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($crl, CURLOPT_POST,true);
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($crl);
		curl_close($crl);
		
		$response=json_decode($res,true);

		if(isset($response['links']['paymentUrl']))
		{
			echo "<h2>Redirecting to Molliepay</h2><script>window.location.href='".$response['links']['paymentUrl']."';</script>";
			
		}		
				
    }
	
	
	protected function getOnepage()
    {
        return $this->_objectManager->get('Magento\Checkout\Model\Type\Onepage');
    }
}