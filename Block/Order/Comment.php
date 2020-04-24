<?php

namespace Meetanshi\NoContact\Block\Order;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;

class Comment extends Template
{
    const COMMENT_FIELD_NAME = 'nocontact_order_comment';

    protected $coreRegistry = null;

    public function __construct(
        TemplateContext $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->coreRegistry = $registry;
        $this->_isScopePrivate = true;
        $this->_template = 'order/view/comment.phtml';
        parent::__construct($context, $data);
    }

    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }

    public function getOrderComment()
    {
        return trim($this->getOrder()->getData(self::COMMENT_FIELD_NAME));
    }

    public function hasOrderComment()
    {
        return strlen($this->getOrderComment()) > 0;
    }

    public function getOrderCommentHtml()
    {
        return nl2br($this->escapeHtml($this->getOrderComment()));
    }
}
