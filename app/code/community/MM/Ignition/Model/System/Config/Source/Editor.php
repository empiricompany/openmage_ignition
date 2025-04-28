<?php

declare(strict_types=1);

use Spatie\Ignition\Config\IgnitionConfig;

class MM_Ignition_Model_System_Config_Source_Editor
{
    /**
     * Get available editor from Ignition config
     *
     * @return array<string, mixed>|bool|string|null
     */
    public static function getOptions(): array|bool|string|null
    {
        $options = (new IgnitionConfig())->toArray();
        return $options['editorOptions'];
    }

    /**
     * Get available editor options
     *
     * @return array<array<string, string>>
     */
    public function toOptionArray()
    {
        $options = [];
        $config = self::getOptions();

        if (!is_iterable($config)) {
            return $options;
        }

        /** @var array<string, array<string, string>> $config */
        foreach ($config as $key => $value) {
            $options[] = [
                'value' => $key,
                'label' => $value['label'],
            ];
        }
        return $options;
    }
}
