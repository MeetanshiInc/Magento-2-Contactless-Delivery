<?php

namespace Meetanshi\NoContact\Plugin\Model\Checkout;

use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\Filter\FilterManager;
use Magento\Sales\Model\Order\Status\HistoryFactory;
use Magento\Sales\Model\OrderFactory;

class PaymentInformationManagement
{
    protected $historyFactory;
    protected $orderFactory;
    protected $jsonHelper;
    protected $_filterManager;

    const COMMENT_FIELD_NAME = 'nocontact_order_comment';

    public function __construct(
        Data $jsonHelper,
        FilterManager $filterManager,
        HistoryFactory $historyFactory,
        OrderFactory $orderFactory
    )
    {
        $this->jsonHelper = $jsonHelper;
        $this->_filterManager = $filterManager;
        $this->historyFactory = $historyFactory;
        $this->orderFactory = $orderFactory;
    }

    public function aroundSavePaymentInformation(
        \Magento\Checkout\Model\PaymentInformationManagement $subject,
        \Closure $proceed,
        $cartId,
        PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    )
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');

        $comment = NULL;
        $requestBody = file_get_contents('php://input');
        $data = $this->jsonHelper->jsonDecode($requestBody);
        if (isset ($data['comments'])) {
            if ($data['comments']) {
                $comment = $this->_filterManager->stripTags($data['comments']);
                //$comment = __('Order Comment: ') . $comment;
                $checkoutSession->setNoContactstext($comment);
            }
        }
        $result = $proceed($cartId, $paymentMethod, $billingAddress);

        return $result;
    }

    public function aroundPlaceOrder(
        \Magento\Quote\Model\QuoteManagement $subject,
        \Closure $proceed,
        $cartId,
        PaymentInterface $paymentMethod = null
    )
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');
        $comment = $checkoutSession->getNoContactstext();

        $orderId = $proceed($cartId, $paymentMethod);
        if ($comment) {
            $order = $this->orderFactory->create()->load($orderId);
            if ($order->getEntityId()) {
                $order->setData(self::COMMENT_FIELD_NAME, $comment);
                $order->save();
                $checkoutSession->setNoContactstext("");
            }
        }

        return $orderId;
    }
}
