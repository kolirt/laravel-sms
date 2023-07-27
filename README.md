# Laravel Sms 

## Installation
```
$ composer require kolirt/laravel-sms
```
```
$ php artisan sms:install
```

## Usage
All available drivers
- [Turbosms](#turbosms)
- [Sigmasms](#sigmasms)
- [Smsc](#smsc)

### Turbosms
Configure for ``config/service.php``
```php
'turbosms' => [
    'login' => env('SMS_TURBOSMS_LOGIN'),
    'password' => env('SMS_TURBOSMS_PASSWORD'),
    'sender' => env('SMS_TURBOSMS_SENDER'),
    'package' => \Kolirt\Sms\Packages\TurboSms::class
],
```

##### Send message
```php
$message = Kolirt\Sms\Facades\Sms::driver('turbosms')->send('380900000000', $message);

// OR

$messages = Kolirt\Sms\Facades\Sms::driver('turbosms')->send(['380900000000', '380900000001'], $message);
```

##### Get status
```php
$message = Kolirt\Sms\Facades\Sms::driver('turbosms')->status($message_id);
```

##### Get balance
```php
$message = Kolirt\Sms\Facades\Sms::driver('turbosms')->balance();
```

### Sigmasms

Configure for ``config/service.php``
```php
'sigmasms' => [
    'login' => env('SMS_TURBOSMS_LOGIN'),
    'password' => env('SMS_TURBOSMS_PASSWORD'),
    'time_cache' => 21600,
    'sender' => [
        'sms' => env('SMS_TURBOSMS_SENDER_SMS'),
        'viber' => env('SMS_TURBOSMS_SENDER_VIBER'),
        'vk' => env('SMS_TURBOSMS_SENDER_VK'),
        'whats_app' => env('SMS_TURBOSMS_SENDER_WHATS_APP')
    ],
    'package' => \Kolirt\Sms\Packages\SigmaSms::class
],
```

##### Send message
```php
$message = Kolirt\Sms\Facades\Sms::driver('sigmasms')->send('380900000000', $message);

// OR

$messages = Kolirt\Sms\Facades\Sms::driver('sigmasms')->send(['380900000000', '380900000001'], $message);
```

##### Send Viber message
```php
$message = Kolirt\Sms\Facades\Sms::driver('sigmasms')->sendViber('380900000000', $text, $image = null, $button_text = null, $button_url = null);

// OR

$messages = Kolirt\Sms\Facades\Sms::driver('sigmasms')->sendViber(['380900000000', '380900000001'], $text, $image = null, $button_text = null, $button_url = null);
```

##### Send WhatsApp message
```php
$message = Kolirt\Sms\Facades\Sms::driver('sigmasms')->sendWhatsApp('380900000000', $text, $image = null);

// OR

$messages = Kolirt\Sms\Facades\Sms::driver('sigmasms')->sendWhatsApp(['380900000000', '380900000001'], $text, $image = null);
```

##### Send VK message
```php
$message = Kolirt\Sms\Facades\Sms::driver('sigmasms')->sendVk('380900000000', $text);

// OR

$messages = Kolirt\Sms\Facades\Sms::driver('sigmasms')->sendVk(['380900000000', '380900000001'], $text);
```

##### Get status
```php
$message = Kolirt\Sms\Facades\Sms::driver('sigmasms')->status($message_id);
```

### Smsc

Configure for ``config/service.php``
```php
'smsc' => [
    'login' => env('SMS_SMSC_LOGIN'),
    'password' => env('SMS_SMSC_PASSWORD'),
    'sender' => env('SMS_SMSC_SENDER'),
    'time' => 0,
    'package' => \Kolirt\Sms\Packages\Smsc::class
],
```

##### Send message
```php
$message = Kolirt\Sms\Facades\Sms::driver('smsc')->send('380900000000', $message);

// OR

$messages = Kolirt\Sms\Facades\Sms::driver('smsc')->send(['380900000000', '380900000001'], $message);
```

##### Get status
```php
$message = Kolirt\Sms\Facades\Sms::driver('smsc')->status($recepient, $message_id);
```

##### Get balance
```php
$message = Kolirt\Sms\Facades\Sms::driver('smsc')->balance();
```
