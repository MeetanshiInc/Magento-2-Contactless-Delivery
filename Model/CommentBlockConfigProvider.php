<?php

namespace Meetanshi\NoContact\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Meetanshi\NoContact\Helper\Data;

class CommentBlockConfigProvider implements ConfigProviderInterface
{
    protected $helper;

    public function __construct(
        Data $helper
    )
    {
        $this->helper = $helper;
    }

    public function getConfig()
    {
        $displayConfig = [];

        $enabled = $this->helper->getIsEnable();
        $displayConfig['show_comment_block'] = ($enabled) ? true : false;
        $displayConfig['nocontact_label'] = $this->helper->getCheckoutTitle();
        $displayConfig['nocontact_description'] = $this->helper->getCheckoutDescription();
        $displayConfig['allow_payment'] = $this->helper->getAllowPaymentMethod();
        $displayConfig['allow_shipping'] = $this->helper->getAllowShippingMethod();

        return $displayConfig;
    }
}