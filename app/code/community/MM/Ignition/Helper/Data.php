<?php
class MM_Ignition_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'dev/mm_ignition/enabled';

    /**
     * Check if Ignition should be printed
     * only if Ignition is enabled and developer mode is on
     * @return bool
     */
    public function shouldPrintIgnition()
    {
        if (!$this->isEnabled()) {
            return false;
        }
        if (!Mage::getIsDeveloperMode()) {
            return false;
        }

        return true;
    }

    /**
     * Check if Ignition is enabled
     * @return bool
     */
    public function isEnabled()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED);
    }
}