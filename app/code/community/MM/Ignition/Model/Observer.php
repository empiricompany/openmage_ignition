<?php

use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\Ignition;

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
        if (!$this->getHelper()->shouldPrintIgnition()) {
            return;
        }

        $observer->getEvent()->getApp()->setErrorHandler(NULL);
        $this->getIgnitionInstance()->register();
    }
    
    /**
     * Handle Exception with Ignition.
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function handleIgnitionException(Varien_Event_Observer $observer)
    {
        if (!$this->getHelper()->shouldPrintIgnition()) {
            return;
        }

        $e = $observer->getEvent()->getException();
        $this->getIgnitionInstance()->handleException($e);

        die();
    }

    /**
     * Get the Ignition instance.
     *
     * @return \Spatie\Ignition\Ignition
     */
    protected function getIgnitionInstance()
    {
        return Ignition::make()
            ->setConfig($this->getIgnitionConfig())
            ->applicationPath(Mage::getBaseDir());
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
     * Get system config.
     * 
     * @return array
     */
    protected function getSystemConfig()
    {
        return [
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