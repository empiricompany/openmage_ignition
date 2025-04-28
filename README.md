# OpenMage Spatie-Ignition Integration
[![Latest Version on Packagist](https://img.shields.io/packagist/v/empiricompany/openmage_ignition.svg?style=flat-square)](https://packagist.org/packages/empiricompany/openmage_ignition)
[![Total Downloads](https://img.shields.io/packagist/dt/empiricompany/openmage_ignition.svg?style=flat-square)](https://packagist.org/packages/empiricompany/openmage_ignition)

**Easily integrate [Spatie Ignition](https://github.com/spatie/ignition) error pages into your OpenMage installation!**

> Thanks to [@fballiano](https://github.com/fballiano) for the brilliant idea started here:  
> https://github.com/OpenMage/magento-lts/pull/3954

---

## Requirements
This module requires the `mage_run_installed_exception` event, introduced in **OpenMage 20.7.0**, to properly catch unhandled exceptions.

---

## Installation

### Install via Composer
```bash
composer require --dev empiricompany/openmage_ignition
```

---

### Manual Core Patch (if needed)
If you prefer to manually patch OpenMage, add the following event dispatch inside `app/Mage.php`:

```php
self::dispatchEvent('mage_run_installed_exception', ['exception' => $e]);
```

![mage_run_installed_exception](https://github.com/empiricompany/openmage_ignition/assets/5071467/27c16ef9-f9ee-4402-a181-570099076db7)

Alternatively, you can apply this patch directly via Composer:

```json
"patches": {
    "openmage/magento-lts": {
        "Add mage_run_installed_exception event for unhandled exceptions (#3613)": "https://github.com/OpenMage/magento-lts/pull/3613.patch"
    }
}
```

---

## Configuration
Navigate to **System > Configuration > Advanced > Developer > Ignition Settings**:

![settings](https://github.com/empiricompany/openmage_ignition/assets/5071467/d101ac76-92c2-40b3-8dcd-67efa9d1779c)

Available settings:

1. **Enabled** — Enable or disable Ignition (default: enabled).
2. **Default Editor** — Set your preferred code editor (default: clipboard).
3. **Default Theme** — Choose between light, dark, or auto (default: auto).
4. **Save Custom Settings in Session** — Allow session-based overrides (default: disabled).
5. **Enable AI-Generated Solutions** — Generate error solutions with OpenAI.

   > **Note**: Requires installing the additional library:  
   > ```bash
   > composer require openai-php/client
   > ```
   > [Reference commit](https://github.com/empiricompany/openmage_ignition/pull/4/files/c5a6f95ccb470190227f807f7d3ca05df4431336#diff-70a2dfcf453f626db44001ac2d126f8d4f665c566c9c69ca0e186fdc56f8491f)

   ⚠️ **Warning**: Caching is not yet implemented — every error will trigger an OpenAI API call.

6. **OpenAI API Key** — API key for OpenAI integration.
7. **Enable Flare** — Enable error tracking with Flare.
8. **Flare API Key** — API key for your Flare project.
9. **Anonymize IP** — Anonymize user IP addresses sent to Flare.

**Note**:  
Saving settings in `.ignition.json` is currently **not supported** — all settings are stored in the OpenMage system configuration or session.

---

## Screenshots

| Ignition Error Page | Flare Integration |
|:-------------------:|:-----------------:|
| ![demo1](https://github.com/empiricompany/openmage_ignition/assets/5071467/f7c18948-de37-4071-b8e7-e185112c89aa) | ![flare](https://github.com/empiricompany/openmage_ignition/assets/5071467/c5399489-7bc0-466b-a0fd-05fb7411780f) |
| ![demo2](https://github.com/empiricompany/openmage_ignition/assets/5071467/7aa46293-4876-4e45-b1fa-d77143d570c0) | ![demo3](https://github.com/empiricompany/openmage_ignition/assets/5071467/44e34638-5de6-406a-abbc-13d882a8f3e4) |

---

# 🚀 Enjoy a better error handling experience in OpenMage!
