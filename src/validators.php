<?php

use Wicochandra\Captcha\CaptchaValidator;

$this->app->validator->resolver(function($translator, $data, $rules, $messages)
{
    return new CaptchaValidator($translator, $data, $rules, $messages);
});
