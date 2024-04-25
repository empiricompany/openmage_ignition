<?php
class MM_Ignition_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'dev/mm_ignition/enabled';
    const XML_PATH_THEME = 'dev/mm_ignition/theme';
    const XML_PATH_EDITOR = 'dev/mm_ignition/editor';
    const XML_PATH_OVERRIDE_CONFIG = 'dev/mm_ignition/override_config';

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

    /**
     * Get theme preference
     * @return string
     */
    public function getTheme()
    {
        return $this->getSessionConfig('theme') ?: Mage::getStoreConfig(self::XML_PATH_THEME);
    }

    /**
     * Get editor preference
     * @return string
     */
    public function getEditor()
    {
        return $this->getSessionConfig('editor') ?: Mage::getStoreConfig(self::XML_PATH_EDITOR);
    }

    /**
     * Check if config should be read from session
     * @return bool
     */
    public function shouldReadConfigFromSession()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_OVERRIDE_CONFIG);
    }

    /**
     * Read config from session
     * @param $key string config key like (theme|editor)
     * @return mixed
     */
    public function getSessionConfig($key)
    {
        if (!$this->shouldReadConfigFromSession()) {
            return false;
        }
        $ignitionConfig = Mage::getSingleton('core/session')->getIgnitionConfig();
        if (is_array($ignitionConfig) && array_key_exists($key, $ignitionConfig)) {
            return $ignitionConfig[$key];
        }
        return false;
    }

}