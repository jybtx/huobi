# laravel 火币 API请求库

```terminal
composer require jybtx/huobi
```

### Laravel

#### >= laravel5.5

ServiceProvider will be attached automatically

#### Other

In your `config/app.php` add `Jybtx\HuobiApi\Providers\HuobiServiceProvider::class` to the end of the `providers` array:

```php
'providers' => [
    ...
    Jybtx\HuobiApi\Providers\HuobiServiceProvider::class,
],
'aliases'  => [
    ...
    "HuobiApi": Jybtx\HuobiApi\Faceds\HuobiApiFacade::class,
]
```
Publish Configuration

```shell
php artisan vendor:publish --provider "Jybtx\HuobiApi\Providers\HuobiServiceProvider"
```