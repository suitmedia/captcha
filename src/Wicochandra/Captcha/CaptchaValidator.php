<?php
namespace Wicochandra\Captcha;

use Illuminate\Validation\Validator;

class CaptchaValidator extends Validator{

    public function validateCaptcha($attribute, $value, $parameters)
    {
        return $value == \Captcha::getCurrentSession();
    }

}
