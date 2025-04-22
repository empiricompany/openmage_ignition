<?php

declare(strict_types=1);

class MM_Ignition_ConfigController extends Mage_Core_Controller_Front_Action
{
    /**
     * @throws Zend_Controller_Response_Exception
     */
    public function updateAction(): void
    {
        /** @var array<string> $params */
        $params = $this->getRequest()->getParams();
        $result = $this->updateConfig($params);
        $resonse = $this->getResponse();
        if (!$result) {
            $resonse->setHttpResponseCode(400);
        }

        $resonse->setHeader('Content-type', 'application/json');
        $resonse->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * @param array<string> $config
     */
    private function updateConfig(array $config): bool
    {
        /** @var MM_Ignition_Helper_Data $_helper */
        $_helper = Mage::helper('mm_ignition');
        if (isset($config['theme'])) {
            $_helper->setTheme($config['theme']);
        }
        if (isset($config['editor'])) {
            $_helper->setEditor($config['editor']);
        }
        return true;
    }
}
