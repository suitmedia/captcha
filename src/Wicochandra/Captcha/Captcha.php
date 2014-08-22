<?php
namespace Wicochandra\Captcha;

use SimpleCaptcha;

class Captcha extends SimpleCaptcha {

    public function __construct($config = array()) {
        parent::__construct($config);
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getCurrentSession() {
        return \Session::get($this->session_var);
    }

    public function url() {
        return route('captcha');
    }


    /**
     * File generation
     */
    protected function WriteImage() {
        ob_start();
        if ($this->imageFormat == 'png' && function_exists('imagepng')) {
            imagepng($this->im);
        } else {
            imagejpeg($this->im, null, 80);
        }
        $this->data = ob_get_clean();
    }

    public function CreateImage() {
        parent::CreateImage();

        $headers = [];
        if ($this->imageFormat == 'png') {
            $headers['content-type'] = 'image/png';
        } else {
            $headers['content-type'] = 'image/jpeg';
        }
        return \Response::make($this->data, 200, $headers);
    }

    /**
     * Text insertion
     */
    protected function WriteText($text, $fontcfg = array()) {
        if (empty($fontcfg)) {
            // Select the font configuration
            $fontcfg  = $this->fonts[array_rand($this->fonts)];
        }

        // Full path of font file
        $fontfile = public_path('packages/wicochandra/captcha/fonts/'.$fontcfg['font']);


        /** Increase font-size for shortest words: 9% for each glyp missing */
        $lettersMissing = $this->maxWordLength-strlen($text);
        $fontSizefactor = 1+($lettersMissing*0.09);

        // Text generation (char by char)
        $x      = 20*$this->scale;
        $y      = round(($this->height*27/40)*$this->scale);
        $length = strlen($text);
        for ($i=0; $i<$length; $i++) {
            $degree   = rand($this->maxRotation*-1, $this->maxRotation);
            $fontsize = rand($fontcfg['minSize'], $fontcfg['maxSize'])*$this->scale*$fontSizefactor;
            $letter   = substr($text, $i, 1);

            if ($this->shadowColor) {
                $coords = imagettftext($this->im, $fontsize, $degree,
                    $x+$this->scale, $y+$this->scale,
                    $this->GdShadowColor, $fontfile, $letter);
            }
            $coords = imagettftext($this->im, $fontsize, $degree,
                $x, $y,
                $this->GdFgColor, $fontfile, $letter);
            $x += ($coords[2]-$x) + ($fontcfg['spacing']*$this->scale);
        }

        $this->textFinalX = $x;
    }

}
