<?php

class MM_Ignition_ConfigController extends Mage_Core_Controller_Front_Action
{

    public function updateAction()
    {
        $result = $this->updateConfig($this->getRequest()->getParams());
        if (!$result) {
            $this->getResponse()->setHttpResponseCode(400);
        }
        
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    private function updateConfig($config)
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