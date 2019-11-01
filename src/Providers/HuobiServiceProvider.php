<?php

namespace Jybtx\HuobiApi\Providers;

use Illuminate\Support\ServiceProvider;
use Jybtx\HuobiApi\HuobiApiInterfaceClient;

class HuobiServiceProvider extends ServiceProvider
{
	/**
     * Merge configuration.
     * @author jybtx
     * @date   2019-11-01
     * @return [type]     [description]
     */
    private function mergeConfig()
    {
    	$this->mergeConfigFrom([
            __DIR__."/../../config/huobi-config.php" => config_path('huobi-config.php'),
        ]);
    }
    /**
     * Configure package paths.
     */
    private function configurePaths()
    {
        $this->publishes([
            __DIR__."/../../config/huobi-config.php" => config_path('huobi-config.php'),
        ],'huobi-config');
    }
    /**
     * [getRegisterSingleton description]
     * @author jybtx
     * @date   2019-11-01
     * @return [type]     [description]
     */
    private function getRegisterSingleton()
    {
    	$this->app->singleton('HuobiApi', function ($app) {
            $config = $app['config']['services']['huobi-config']??null;
            if ( is_null( $config ) ) {
                $config = $app['config']['huobi-config'] ?: $app['config']['huobi-config::config'];
            }
            return new HuobiApiInterfaceClient($config['huobi_account_id'], $config['huobi_access_key'],$config['huobi_secret_key'],$config['huobi_api_url']);
        });
    }
	/**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configurePaths();
        $this->getRegisterSingleton();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfig();
    }
    
}