<?php

namespace Meetanshi\NoContact\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Option\ArrayInterface;
use Magento\Shipping\Model\Config as ShippingConfig;
use Magento\Store\Model\ScopeInterface;

class Shipping implements ArrayInterface
{
    protected $shippingConfig;
    protected $scopeConfig;

    public function __construct(
        ShippingConfig $shippingConfig,
        ScopeConfigInterface $scopeConfig
    ) {

        $this->shippingConfig = $shippingConfig;
        $this->scopeConfig    = $scopeConfig;
    }

    public function toOptionArray()
    {
        $carriers = $this->shippingConfig->getAllCarriers();
        foreach ($carriers as $carrierCode => $carrierModel) {
            $carrierMethods = $carrierModel->getAllowedMethods();
            if (!$carrierMethods) {
                continue;
            }

            $isEnable = $this->scopeConfig->getValue(
                'carriers/' . $carrierCode . '/active',
                ScopeInterface::SCOPE_STORE
            );

            if (!$isEnable) {
                continue;
            }

            $carrierTitle          = $this->scopeConfig->getValue(
                'carriers/' . $carrierCode . '/title',
                ScopeInterface::SCOPE_STORE
            );

            $methods[$carrierCode] = ['label' => $carrierTitle, 'value' => []];
            foreach ($carrierMethods as $methodCode => $methodTitle) {
                if (is_array($methodTitle)) {
                    continue;
                }
                $methods[$carrierCode]['value'][] = [
                    'value' => $carrierCode . '_' . $methodCode,
                    'label' => '[' . $carrierCode . '] ' . ($methodTitle ? $methodTitle : $methodCode),
                ];
            }
        }

        if (empty($methods)) {
            $methods = [
                'label' => [],
                'value' => []
            ];
        }

        return $methods;
    }
}
