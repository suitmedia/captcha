<?php
$this->app->router->get('captcha/image', ['as' => 'captcha', 'middleware' => '\Illuminate\Session\Middleware\StartSession', function () {
    return \Captcha::CreateImage();
}]);
