<?php

use Spatie\Ignition\Config\IgnitionConfig;
class MM_Ignition_Model_System_Config_Source_Editor
{
    /**
     * Get available editor from Ignition config
     *
     * @return array
     */
    public static function getOptions()
    {
        $editorOptions = (new IgnitionConfig())->toArray()['editorOptions'];
        return $editorOptions;
    }

    /**
     * Get available editor options
     *
     * @return array
     */
    public function toOptionArray()
    {
        foreach ($this->getOptions() as $key => $value) {
            $options[] = [
                'value' => $key,
                'label' => $value['label']
            ];
        }
        return $options;
    }
}