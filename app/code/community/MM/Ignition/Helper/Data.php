<?php
class MM_Ignition_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'dev/mm_ignition/enabled';
    const XML_PATH_THEME = 'dev/mm_ignition/theme';
    const XML_PATH_EDITOR = 'dev/mm_ignition/editor';
    const XML_PATH_OVERRIDE_CONFIG = 'dev/mm_ignition/override_config';
    
    /**
     * Allowed keys for settings
     * @var array
     */
    const SETTINGS_ALLOWED_KEYS = ['theme', 'editor', 'hide_solutions'];

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
     * Set theme preference
     * @return string
     */
    public function setTheme($theme)
    {
        if (!in_array($theme, MM_Ignition_Model_System_Config_Source_Theme::OPTIONS)) {
            return false;
        }
        $this->setSessionConfig('theme', $theme);
        if ($this->shouldUseSessionConfig()) {
            return true;
        }
        Mage::getConfig()->saveConfig(self::XML_PATH_THEME, $theme);
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
     * Set editor preference
     * @return string
     */
    public function setEditor($editor)
    {
        $editorOptions = array_keys((MM_Ignition_Model_System_Config_Source_Editor::getOptions()));
        if (!in_array($editor, $editorOptions)) {
            return false;
        }
        $this->setSessionConfig('editor', $editor);
        if ($this->shouldUseSessionConfig()) {
            return true;
        }
        Mage::getConfig()->saveConfig(self::XML_PATH_EDITOR, $editor);
    }

    /**
     * Check if config should be read from session
     * @return bool
     */
    public function shouldUseSessionConfig()
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
        if (!$this->shouldUseSessionConfig()) {
            return false;
        }
        $ignitionConfig = Mage::getSingleton('core/session')->getIgnitionConfig();
        if (is_array($ignitionConfig) && array_key_exists($key, $ignitionConfig)) {
            return $ignitionConfig[$key];
        }
        return false;
    }

    /**
     * Write config from session
     * @param $key string config key like (theme|editor)
     * @param $value string config value
     * @return void
     */
    public function setSessionConfig($key, $value)
    {
        if (!$this->shouldUseSessionConfig()) {
            return false;
        }
        if (!in_array($key, self::SETTINGS_ALLOWED_KEYS)) {
            return false;
        }
        $ignitionConfig = Mage::getSingleton('core/session')->getIgnitionConfig() ?: [];
        $ignitionConfig[$key] = $value;
        Mage::getSingleton('core/session')->setIgnitionConfig($ignitionConfig);
    }

}