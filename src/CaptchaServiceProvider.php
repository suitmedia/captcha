<?php namespace Wicochandra\Captcha;

use Illuminate\Support\ServiceProvider;

use Wicochandra\Captcha\Captcha;

class CaptchaServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('captcha.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/captcha'),
        ], 'public');

        include __DIR__.'/routes.php';
        include __DIR__.'/validators.php';
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('captcha', function($app) {
            return new Captcha($app->config->get('captcha'), $app['session'], $app->make('Illuminate\Contracts\Routing\ResponseFactory'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('captcha');
    }

}
