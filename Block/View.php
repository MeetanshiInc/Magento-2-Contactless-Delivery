<?php

namespace Meetanshi\NoContact\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\AbstractProduct;
use Meetanshi\NoContact\Helper\Data;

class View extends AbstractProduct
{
    protected $helperData;

    public function __construct(
        Context $context,
        Data $helperData,
        array $data
    )
    {
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }

    public function getTitle()
    {
        return $this->helperData->getProductTitle();
    }

    public function getDescription()
    {
        return $this->helperData->getProductDescription();
    }
}
