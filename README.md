# huobi 
laravel 火币 API请求库

```terminal
composer require jybtx/huobi
```

### Laravel

#### >= laravel5.5

ServiceProvider will be attached automatically

#### Other

In your `config/app.php` add `Jybtx\HuoBiApi\Providers\HuobiServiceProvider::class` to the end of the `providers` array:

```php
'providers' => [
    ...
    Jybtx\HuoBiApi\Providers\HuobiServiceProvider::class,
],
'aliases'  => [
    ...
    "HuobiApi": Jybtx\HuoBiApi\Faceds\HuobiFacade::class,
]
```
Publish Configuration

```shell
php artisan vendor:publish --provider "JJybtx\HuoBiApi\Providers\HuobiServiceProvider"
```