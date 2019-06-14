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
