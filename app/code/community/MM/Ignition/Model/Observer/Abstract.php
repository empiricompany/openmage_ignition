<?php

declare(strict_types=1);

use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\Ignition;
use Spatie\Ignition\Solutions\OpenAi\OpenAiSolutionProvider;
use Spatie\FlareClient\Flare;

abstract class MM_Ignition_Model_Observer_Abstract extends Mage_Core_Model_Observer
{
    /**
     * Get helper data.
     */
    protected function getHelper(): MM_Ignition_Helper_Data
    {
        /** @var MM_Ignition_Helper_Data $helper */
        $helper = Mage::helper('mm_ignition');
        return $helper;
    }

    /**
     * Get helper Flare.
     */
    protected function getFlareHelper(): MM_Ignition_Helper_Flare
    {
        /** @var MM_Ignition_Helper_Flare $helper */
        $helper = Mage::helper('mm_ignition/flare');
        return $helper;
    }

    /**
     * Get helper OpenAi.
     */
    protected function getOpenAiHelper(): MM_Ignition_Helper_OpenAi
    {
        /** @var MM_Ignition_Helper_OpenAi $helper */
        $helper = Mage::helper('mm_ignition/openAi');
        return $helper;
    }

    /**
     * Get the Ignition instance.
     */
    protected function getIgnitionInstance(): Ignition
    {
        $_ignition = Ignition::make()
            ->runningInProductionEnvironment(!Mage::getIsDeveloperMode())
            ->setConfig($this->getIgnitionConfig())
            ->applicationPath(Mage::getBaseDir());

        $openAiHelper = $this->getOpenAiHelper();
        if ($openAiHelper->isOpenAiEnabled() && !empty($openAiHelper->getOpenAiKey())) {
            $openAiKey = $openAiHelper->getOpenAiKey();
            $aiSolutionProvider = new OpenAiSolutionProvider($openAiKey);
            $aiSolutionProvider->applicationType('OpenMage a fork of Magetno 1.9 (Generic Developer Documentation: https://devdocs-openmage.org/ NO mention Magento 1.x)');

            $_ignition->addSolutionProviders([
                $aiSolutionProvider,
            ]);
        }

        $flareHelper = $this->getFlareHelper();
        if ($flareHelper->isFlareEnabled() && !empty($flareHelper->getFlareApiKey())) {
            $_ignition->sendToFlare($flareHelper->getFlareApiKey());
            if ($flareHelper->shouldAnonymizeIp()) {
                $_ignition->configureFlare(function (Flare $flare) {
                    $flare->anonymizeIp();
                });
            }
        }

        return $_ignition;
    }

    /**
     * Get the Ignition config.
     */
    protected function getIgnitionConfig(): IgnitionConfig
    {
        return (new IgnitionConfig())
            ->merge($this->getSystemConfig());
    }

    /**
     * Get settings from system config.
     *
     * @return array<string, string>
     */
    protected function getSystemConfig(): array
    {
        $helper = $this->getHelper();
        return [
            'editor' => $helper->getEditor() ?? 'vscode',
            'theme' => $helper->getTheme() ?? 'auto',
        ];
    }
}
