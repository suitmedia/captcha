<?php
$this->app->router->get('captcha/image', [
    'as' => 'captcha',
    'middleware' => [
        '\Illuminate\Cookie\Middleware\EncryptCookies',
        '\Illuminate\Session\Middleware\StartSession',
    ],
    function () {
        return \Captcha::CreateImage();
}]);
