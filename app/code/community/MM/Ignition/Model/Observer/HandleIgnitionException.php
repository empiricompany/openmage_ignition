<?php

declare(strict_types=1);

class MM_Ignition_Model_Observer_HandleIgnitionException extends MM_Ignition_Model_Observer_Abstract
{
    /**
     * Handle Exception with Ignition.
     */
    public function execute(Varien_Event_Observer $observer): void
    {
        if (!$this->getHelper()->shouldPrintIgnition() && !$this->getFlareHelper()->isFlareEnabled()) {
            return;
        }

        $exception = $observer->getEvent()->getDataByKey('exception');
        if ($exception instanceof Throwable) {
            $this->getIgnitionInstance()->handleException($exception);
        }

        if ($this->getHelper()->shouldPrintIgnition()) {
            die();
        }
    }
}
