<?php

declare(strict_types=1);

class MM_Ignition_Model_System_Config_Source_Theme
{
    /**
     * Available theme options
     */
    public const OPTIONS = [
        'auto',
        'light',
        'dark',
    ];

    /**
     * Get available theme options
     *
     * @return array<array<string, string>>
     */
    public function toOptionArray(): array
    {
        $options = [];
        foreach (self::OPTIONS as $option) {
            $options[] = [
                'value' => $option,
                'label' => ucfirst($option),
            ];
        }
        return $options;
    }
}
