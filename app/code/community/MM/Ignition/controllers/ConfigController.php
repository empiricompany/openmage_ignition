<?php

class MM_Ignition_ConfigController extends Mage_Core_Controller_Front_Action
{
    const SETTINGS_ALLOWED_KEYS = ['theme', 'editor', 'hide_solutions'];

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
        $config = array_intersect_key($config, array_flip(self::SETTINGS_ALLOWED_KEYS));

        if (isset($config['theme']) && in_array($config['theme'], MM_Ignition_Model_System_Config_Source_Theme::OPTIONS)) {
            Mage::getConfig()->saveConfig('dev/mm_ignition/theme', $config['theme']);
        }
        
        $editorOptions = array_keys((MM_Ignition_Model_System_Config_Source_Editor::getOptions()));
        if (isset($config['editor']) && in_array($config['editor'], $editorOptions)) {
            Mage::getConfig()->saveConfig('dev/mm_ignition/editor', $config['editor']);
        }
        
        Mage::getSingleton('core/session')->setIgnitionConfig($config);
        return true;
    }
}