<?php

namespace Meetanshi\NoContact\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const CONFIG_ENABLE = 'nocontact/general/enable';
    const CONFIG_ALLOW_PAYMENT = 'nocontact/general/payment_methods';
    const CONFIG_ALLOW_SHIPPING = 'nocontact/general/shipping_methods';
    const CONFIG_CHECKOUT_LABLE = 'nocontact/general/label_checkout';
    const CONFIG_CHECKOUT_DESCRIPTION = 'nocontact/general/description_checkout';
    const CONFIG_PRODUCT_LABLE = 'nocontact/general/label_product';
    const CONFIG_PRODUCT_DESCRIPTION = 'nocontact/general/description_product';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function getIsEnable()
    {
        return $this->scopeConfig->getValue(self::CONFIG_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    public function getAllowPaymentMethod()
    {
        return $this->scopeConfig->getValue(self::CONFIG_ALLOW_PAYMENT, ScopeInterface::SCOPE_STORE);
    }

    public function getAllowShippingMethod()
    {
        return $this->scopeConfig->getValue(self::CONFIG_ALLOW_SHIPPING, ScopeInterface::SCOPE_STORE);
    }

    public function getCheckoutTitle()
    {
        return $this->scopeConfig->getValue(self::CONFIG_CHECKOUT_LABLE, ScopeInterface::SCOPE_STORE);
    }

    public function getCheckoutDescription()
    {
        return $this->scopeConfig->getValue(self::CONFIG_CHECKOUT_DESCRIPTION, ScopeInterface::SCOPE_STORE);
    }

    public function getProductTitle()
    {
        return $this->scopeConfig->getValue(self::CONFIG_PRODUCT_LABLE, ScopeInterface::SCOPE_STORE);
    }

    public function getProductDescription()
    {
        return $this->scopeConfig->getValue(self::CONFIG_PRODUCT_DESCRIPTION, ScopeInterface::SCOPE_STORE);
    }
}