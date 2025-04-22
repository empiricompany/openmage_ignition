<?php

declare(strict_types=1);

class MM_Ignition_Model_Observer_HandleIgnitionRegister extends MM_Ignition_Model_Observer_Abstract
{
    /**
     * Register Ignition error handler.
     */
    public function execute(Varien_Event_Observer $observer): void
    {
        if (!$this->getHelper()->shouldPrintIgnition() && !$this->getFlareHelper()->isFlareEnabled()) {
            return;
        }

        Mage::app()->setErrorHandler(null);
        $this->getIgnitionInstance()->register(error_reporting());
    }
}
