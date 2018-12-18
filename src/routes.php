<?php

$this->app->router->get('captcha/image', [
    'as' => 'captcha',
    'uses' => 'Wicochandra\Captcha\Controllers\CaptchaController@show'
]);
