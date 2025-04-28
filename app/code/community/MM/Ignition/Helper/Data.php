<?php

declare(strict_types=1);

class MM_Ignition_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_moduleName = 'MM_Ignition';

    public const XML_PATH_ENABLED = 'dev/mm_ignition/enabled';
    public const XML_PATH_THEME = 'dev/mm_ignition/theme';
    public const XML_PATH_EDITOR = 'dev/mm_ignition/editor';
    public const XML_PATH_OVERRIDE_CONFIG = 'dev/mm_ignition/override_config';

    /**
     * Allowed keys for settings
     */
    public const SETTINGS_ALLOWED_KEYS = ['theme', 'editor', 'hide_solutions'];

    /**
     * Check if Ignition should be printed
     *
     * Only if Ignition is enabled and developer mode is on
     */
    public function shouldPrintIgnition(): bool
    {
        if (!$this->isEnabled() || !Mage::getIsDeveloperMode()) {
            return false;
        }

        return true;
    }

    /**
     * Check if Ignition is enabled
     */
    public function isEnabled(): bool
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED);
    }

    /**
     * Get theme preference
     */
    public function getTheme(): ?string
    {
        return $this->getSessionConfig('theme') ?: Mage::getStoreConfig(self::XML_PATH_THEME);
    }

    /**
     * Set theme preference
     */
    public function setTheme(string $theme): bool
    {
        if (!in_array($theme, MM_Ignition_Model_System_Config_Source_Theme::OPTIONS)) {
            return false;
        }
        $this->setSessionConfig('theme', $theme);
        if ($this->shouldUseSessionConfig()) {
            return true;
        }
        Mage::getConfig()->saveConfig(self::XML_PATH_THEME, $theme);
        return true;
    }

    /**
     * Get editor preference
     */
    public function getEditor(): ?string
    {
        return $this->getSessionConfig('editor') ?: Mage::getStoreConfig(self::XML_PATH_EDITOR);
    }

    /**
     * Set editor preference
     */
    public function setEditor(string $editor): bool
    {
        $editorOptions = MM_Ignition_Model_System_Config_Source_Editor::getOptions();
        if (!is_array($editorOptions)) {
            return false;
        }

        $editorOptions = array_keys($editorOptions);
        if (!in_array($editor, $editorOptions)) {
            return false;
        }
        $this->setSessionConfig('editor', $editor);
        if ($this->shouldUseSessionConfig()) {
            return true;
        }
        Mage::getConfig()->saveConfig(self::XML_PATH_EDITOR, $editor);
        return true;
    }

    /**
     * Check if config should be read from session
     */
    public function shouldUseSessionConfig(): bool
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_OVERRIDE_CONFIG);
    }

    /**
     * Read config from session
     * @param string $key config key like (theme|editor)
     * @return mixed
     */
    public function getSessionConfig(string $key)
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
     * @param string $key config key like (theme|editor)
     * @param string $value config value
     */
    public function setSessionConfig(string $key, string $value): void
    {
        if (!$this->shouldUseSessionConfig()) {
            return;
        }
        if (!in_array($key, self::SETTINGS_ALLOWED_KEYS)) {
            return;
        }
        $ignitionConfig = Mage::getSingleton('core/session')->getIgnitionConfig() ?: [];
        $ignitionConfig[$key] = $value;
        Mage::getSingleton('core/session')->setIgnitionConfig($ignitionConfig);
    }
}
