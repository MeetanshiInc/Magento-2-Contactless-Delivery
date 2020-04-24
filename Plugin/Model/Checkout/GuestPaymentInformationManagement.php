<?php
namespace Meetanshi\NoContact\Plugin\Model\Checkout;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\Filter\FilterManager;
use Magento\Sales\Model\Order\Status\HistoryFactory;
use Magento\Sales\Model\OrderFactory;

class GuestPaymentInformationManagement
{
    const COMMENT_FIELD_NAME = 'nocontact_order_comment';

	protected $historyFactory;
	protected $orderFactory;
	protected $jsonHelper;
	protected $filterManagerelper;

    public function __construct(
        Data $jsonHelper,
        FilterManager $filterManager,
		HistoryFactory $historyFactory,
		OrderFactory $orderFactory
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->filterManagerelper = $filterManager;
		$this->historyFactory = $historyFactory;
		$this->orderFactory = $orderFactory;
    }

    public function aroundSavePaymentInformationAndPlaceOrder(
		\Magento\Checkout\Model\GuestPaymentInformationManagement $subject, 
		\Closure $proceed,
        $cartId,
		$email,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress
    ) {	

		$comment = NULL;

		$requestBody = file_get_contents('php://input');
		$data = $this->jsonHelper->jsonDecode($requestBody);
		if (isset ($data['comments'])) {
			if ($data['comments']) {
				$comment = $this->filterManagerelper->stripTags($data['comments']);
				$comment = __('Order Comment: ') . $comment;
			}
		}
		$orderId = $proceed($cartId, $email, $paymentMethod, $billingAddress);
		if ($comment) {
			$order = $this->orderFactory->create()->load($orderId);
			if ($order->getEntityId()) {
                $order->setData(self::COMMENT_FIELD_NAME, $comment);
                $order->save();
            }
		}
		return $orderId;
    }
}