<?php

namespace Wicochandra\Captcha\Controllers;

use Illuminate\Routing\Controller;

class CaptchaController extends Controller
{
    public function show()
    {
        return \Captcha::CreateImage();
    }
}
