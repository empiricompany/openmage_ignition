# OpenMage spatie-ignition integration
[![Latest Version on Packagist](https://img.shields.io/packagist/v/empiricompany/openmage_ignition.svg?style=flat-square)](https://packagist.org/packages/empiricompany/openmage_ignition)
[![Total Downloads](https://img.shields.io/packagist/dt/empiricompany/openmage_ignition.svg?style=flat-square)](https://packagist.org/packages/empiricompany/openmage_ignition)

Integrate ignition error page https://github.com/spatie/ignition in OpenMage!

Thanks to [@fballiano](https://github.com/fballiano) for his smart idea started here:
https://github.com/OpenMage/magento-lts/pull/3954

## Installation

### Patch core files
The module needs a new event `mage_run_installed_exception` to catch exceptions.

Checkout the __'next' branch in development__ which contains the new event 

```cli
composer require "openmage/magento-lts":"dev-next"
```

Or manually patch the file  `app/Mage.php` adding new event

```php
self::dispatchEvent('mage_run_installed_exception', ['exception' => $e]);
```

![mage_run_installed_exception](https://github.com/empiricompany/openmage_ignition/assets/5071467/27c16ef9-f9ee-4402-a181-570099076db7)

- Or apply a patch from this PR:
```json
"patches": {
    "openmage/magento-lts": {
        "Add mage_run_installed_exception event when uncatched exception is thrown #3613": "https://github.com/OpenMage/magento-lts/pull/3613.patch"
    }
}
```

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
6. OpenAI API Key: OpenAI Api Key used to generate solutions

Save settings in file `.ignition.json` is not supported yet, all new settings will be saved directly in system config or in session.

---

## Screenshots

![demo1](https://github.com/empiricompany/openmage_ignition/assets/5071467/f7c18948-de37-4071-b8e7-e185112c89aa)
![demo2](https://github.com/empiricompany/openmage_ignition/assets/5071467/7aa46293-4876-4e45-b1fa-d77143d570c0)
![idemo3](https://github.com/empiricompany/openmage_ignition/assets/5071467/44e34638-5de6-406a-abbc-13d882a8f3e4)


