# OpenMage spatie-ignition integration
[![Latest Version on Packagist](https://img.shields.io/packagist/v/empiricompany/openmage_ignition.svg?style=flat-square)](https://packagist.org/packages/empiricompany/openmage_ignition)
[![Total Downloads](https://img.shields.io/packagist/dt/empiricompany/openmage_ignition.svg?style=flat-square)](https://packagist.org/packages/empiricompany/openmage_ignition)

Integrate ignition error page https://github.com/spatie/ignition in OpenMage!

Thanks to [@fballiano](https://github.com/fballiano) for his smart idea started here:
https://github.com/OpenMage/magento-lts/pull/3954

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
In System/Advanced/Developer section

![settings](https://github.com/empiricompany/openmage_ignition/assets/5071467/f2aaf8d5-1462-426a-b644-6878a6e00030)


1. Enabled: Enable / Disable (enable)
2. Default Editor: set default editor (clipboard)
3. Default Theme: set default theme (auto)
4. Save custom settings in session: Enable if you want custom settings foreach session, otherwise settings will be overrided (disabled)
5. Enable AI Generated Solution: Enable AI Generated Solution by OpenAI (⚠️ Warning: there is no cache implemention yet, so all errors always call OpenAI api)
6. OpenAI API Key: OpenAI Api Key used to genrate solution

Save settings in file `.ignition.json` is not supported yet, all new settings will be saved directly in system config or in session.

---

## Screenshots

![demo1](https://github.com/empiricompany/openmage_ignition/assets/5071467/f7c18948-de37-4071-b8e7-e185112c89aa)

![idemo2](https://github.com/empiricompany/openmage_ignition/assets/5071467/44e34638-5de6-406a-abbc-13d882a8f3e4)


