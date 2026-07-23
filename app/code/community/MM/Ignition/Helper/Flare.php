<?php

declare(strict_types=1);

class MM_Ignition_Helper_Flare extends Mage_Core_Helper_Abstract
{
    protected $_moduleName = 'MM_Ignition';

    public const XML_PATH_FLARE_ENABLED = 'dev/mm_ignition/enable_flare';
    public const XML_PATH_FLARE_API_KEY = 'dev/mm_ignition/flare_api_key';
    public const XML_PATH_FLARE_ANONYMIZE_IP = 'dev/mm_ignition/flare_anonymize_ip';


    /**
     * Check if Flare is enabled
     */
    public function isFlareEnabled(): bool
    {
        try {
            return Mage::getStoreConfigFlag(self::XML_PATH_FLARE_ENABLED);
        } catch (Mage_Core_Model_Store_Exception $e) {
            return false;
        }
    }

    /**
     * Check if Flare should anonymize IP
     */
    public function shouldAnonymizeIp(): bool
    {
        try {
            return Mage::getStoreConfigFlag(self::XML_PATH_FLARE_ANONYMIZE_IP);
        } catch (Mage_Core_Model_Store_Exception $e) {
            return false;
        }
    }

    /**
     * Get Flare API key
     */
    public function getFlareApiKey(): string
    {
        try {
            return (string) Mage::getStoreConfig(self::XML_PATH_FLARE_API_KEY);
        } catch (Mage_Core_Model_Store_Exception $e) {
            return '';
        }
    }
}
