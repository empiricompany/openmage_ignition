# OpenMage spatie-ignition integration

## Installation

### Patch core files
There is an open PR https://github.com/OpenMage/magento-lts/pull/3957 on __next branch__

You have to patch Mage.php and App.php adding this new events:

`Mage.php`
```php
self::dispatchEvent('mage_print_exception_before', ['exception' => $e, 'extra' => $extra]);
```

![mage_print_exception_before](https://github.com/empiricompany/openmage_ignition/assets/5071467/6597b7ad-740a-4a7c-988a-fc96b7bdcf38)

`App.php`
```php
Mage::dispatchEvent('core_app_init_environment_after', ['app' => $this]);
```
![core_app_init_environment_after](https://github.com/empiricompany/openmage_ignition/assets/5071467/78e66e1a-3e7c-41c1-996a-3df0982d3161)

---

### Install composer package 

```cli
composer require empiricompany/openmage_ignition
```

---

## Ignition Settings
![settings](https://github.com/empiricompany/openmage_ignition/assets/5071467/6e14a904-53ef-4941-9270-c1ed4219bbc9)

1. Enabled: Enable / Disable (enable)
2. Default Editor: set default editor (clipboard)
3. Default Theme: set default theme (auto)
4. Save custom settings in session: Enable if you want custom settings foreach session, otherwise settings will be overrided (disabled)

Save settings in file `.ignition.json` is not supported yet, all new settings will be saved directly in system config or in session.

---

## Screenshots

![demo1](https://github.com/empiricompany/openmage_ignition/assets/5071467/f7c18948-de37-4071-b8e7-e185112c89aa)

