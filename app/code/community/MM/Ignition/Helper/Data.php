<?php
class MM_Ignition_Helper extends Mage_Core_Helper_Abstract
{
    public function getIgnitionConfig(): array
    {
        $config = new Spatie\Ignition\Config\IgnitionConfig();
        return $config->toArray();
    }
}