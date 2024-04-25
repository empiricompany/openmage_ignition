<?php

class MM_Ignition_Model_System_Config_Source_Theme
{
    /**
     * Get available theme options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'auto', 'label' => 'Auto'],
            ['value' => 'light', 'label' => 'Light'],
            ['value' => 'dark', 'label' => 'Dark'],
        ];
    }
}