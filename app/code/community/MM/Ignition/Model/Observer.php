<?php
class MM_Ignition_Model_Observer extends Mage_Core_Model_Observer
{
    public function handlePrintExceptionBefore(Varien_Event_Observer $observer)
    {
        $e = $observer->getEvent()->getException();
        \Spatie\Ignition\Ignition::make()
            ->applicationPath(Mage::getBaseDir())
            ->setTheme('dark')
            ->handleException($e);
        die();
    }
}