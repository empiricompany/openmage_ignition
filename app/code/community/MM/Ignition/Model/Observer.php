<?php

use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\Ignition;
use Spatie\Ignition\Solutions\OpenAi\OpenAiSolutionProvider;
use Spatie\FlareClient\Flare;

class MM_Ignition_Model_Observer extends Mage_Core_Model_Observer
{
    /**
     * Register Ignition error handler.
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function handleIgnitionRegister(Varien_Event_Observer $observer)
    {        
        if (!$this->getHelper()->shouldPrintIgnition() && !$this->getHelper()->isFlareEnabled()) {
            return;
        }

        Mage::app()->setErrorHandler(NULL);
        $this->getIgnitionInstance()->register(error_reporting());
    }
    
    /**
     * Handle Exception with Ignition.
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function handleIgnitionException(Varien_Event_Observer $observer)
    {
        if (!$this->getHelper()->shouldPrintIgnition() && !$this->getHelper()->isFlareEnabled()) {
            return;
        }

        $e = $observer->getEvent()->getException();
        $this->getIgnitionInstance()->handleException($e);

        if ($this->getHelper()->shouldPrintIgnition()) {
            die();
        }
    }

    /**
     * Get the Ignition instance.
     *
     * @return \Spatie\Ignition\Ignition
     */
    protected function getIgnitionInstance()
    {
        $_ignition = Ignition::make()
            ->runningInProductionEnvironment(!Mage::getIsDeveloperMode())
            ->setConfig($this->getIgnitionConfig())
            ->applicationPath(Mage::getBaseDir());

        if ($this->getHelper()->isOpenAiEnabled() && !empty($this->getHelper()->getOpenAiKey())) {
            $openAiKey = $this->getHelper()->getOpenAiKey();
            $aiSolutionProvider = new OpenAiSolutionProvider($openAiKey);
            $aiSolutionProvider->applicationType('OpenMage a fork of Magetno 1.9 (Generic Developer Documentation: https://devdocs-openmage.org/ NO mention Magento 1.x)');

            $_ignition->addSolutionProviders([
                $aiSolutionProvider,
            ]);
        }

        if ($this->getHelper()->isFlareEnabled() && !empty($this->getHelper()->getFlareApiKey())) {
            $_ignition->sendToFlare($this->getHelper()->getFlareApiKey());
            if ($this->getHelper()->shouldAnonymizeIp()) {
                $_ignition->configureFlare(function(Flare  $flare) {
                    $flare->anonymizeIp();
                });
            }
        }

        return $_ignition;
    }

    /**
     * Get the Ignition config.
     *
     * @return \Spatie\Ignition\Config\IgnitionConfig
     */
    protected function getIgnitionConfig()
    {
        return (new IgnitionConfig())
            ->merge($this->getSystemConfig());
    }

    /**
     * Get settings from system config.
     * 
     * @return array
     */
    protected function getSystemConfig()
    {
        return [
            'editor' => $this->getHelper()->getEditor() ?? 'vscode',
            'theme' => $this->getHelper()->getTheme() ?? 'auto',
        ];
    }

    /**
     * Get helper data.
     *
     * @return MM_Ignition_Helper_Data
     */
    protected function getHelper()
    {
        return Mage::helper('mm_ignition');
    }
}