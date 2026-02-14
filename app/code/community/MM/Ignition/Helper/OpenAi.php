<?php

declare(strict_types=1);

use Composer\InstalledVersions;

class MM_Ignition_Helper_OpenAi extends Mage_Core_Helper_Abstract
{
    protected $_moduleName = 'MM_Ignition';

    public const XML_PATH_OPENAI_ENABLED = 'dev/mm_ignition/enable_openai';
    public const XML_PATH_OPENAI_KEY = 'dev/mm_ignition/openai_api_key';

    /**
     * Check if OpenAI is enabled
     */
    public function isOpenAiEnabled(): bool
    {
        if (!InstalledVersions::isInstalled('openai-php/client')) {
            return false;
        }

        try {
            return Mage::getStoreConfigFlag(self::XML_PATH_OPENAI_ENABLED);
        } catch (Mage_Core_Model_Store_Exception $e) {
            return false;
        }
    }

    /**
     * Get OpenAI key
     */
    public function getOpenAiKey(): string
    {
        try {
            return (string) Mage::getStoreConfig(self::XML_PATH_OPENAI_KEY);
        } catch (Mage_Core_Model_Store_Exception $e) {
            return '';
        }
    }
}
