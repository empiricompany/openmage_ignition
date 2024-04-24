<?php
class MM_Ignition_Model_Observer extends Mage_Core_Model_Observer
{
    public function handleAppInitBefore(Varien_Event_Observer $observer)
    {
        if( !Mage::getIsDeveloperMode() ) return;

        $observer->getEvent()->getApp()->setErrorHandler(NULL);
        \Spatie\Ignition\Ignition::make()
                ->applicationPath(Mage::getBaseDir())
                ->register();
    }
    
    public function handlePrintExceptionBefore(Varien_Event_Observer $observer)
    {
        if( !Mage::getIsDeveloperMode() ) return;

        $e = $observer->getEvent()->getException();
        \Spatie\Ignition\Ignition::make()
            ->applicationPath(Mage::getBaseDir())
            ->useDarkMode()
            ->handleException($e);
        die();
    }
}