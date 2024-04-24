# OpenMage spatie-ignition integration

## Installation

First you have to patch your Mage.php and App.php adding this new events:

`Mage.php`
```php
self::dispatchEvent('mage_print_exception_before', ['exception' => $e, 'extra' => $extra]);
```

![mage_print_exception_before](https://github.com/empiricompany/openmage_ignition/assets/5071467/6597b7ad-740a-4a7c-988a-fc96b7bdcf38)

`App.php`
```php
Mage::dispatchEvent('core_app_init_before', ['app' => $this]);
```
![core_app_init_before](https://github.com/empiricompany/openmage_ignition/assets/5071467/459f7f31-c203-4542-a7a7-43cc2922972f)


Add this repo to your `composer.json`
```json
    "repositories": [
      { "type": "vcs", "url": "git://github.com/empiricompany/openmage_ignition.git"}
    ]
```

then you can:
```cli
composer require empiricompany/openmage_ignition
```
