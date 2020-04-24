<?php

namespace Meetanshi\NoContact\Plugin\Block\Adminhtml;

use Magento\Sales\Block\Adminhtml\Order\View\Info;

class SalesOrderViewInfo
{
    const COMMENT_FIELD_NAME = 'nocontact_order_comment';

    public function afterToHtml(
        Info $subject,
        $result
    )
    {
        $commentBlock = $subject->getLayout()->getBlock('nocontact_order_comments');
        if ($commentBlock !== false && $subject->getNameInLayout() == 'order_info') {
            $commentBlock->setOrderComment($subject->getOrder()->getData(self::COMMENT_FIELD_NAME));
            $result = $result . $commentBlock->toHtml();
        }

        return $result;
    }
}
