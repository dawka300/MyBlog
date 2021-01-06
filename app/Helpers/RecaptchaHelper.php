<?php

namespace App\Helpers;

use Illuminate\Support\Str;


class RecaptchaHelper {
    public $url = 'https://www.google.com/recaptcha/api/siteverify?secret=??&response=??';
    public $secrect;
    public $postValue;

    public function __construct(string $string){
        $this->secrect = env('GOOGLE_RECAPTCHA_SECRET');
        $this->postValue = $string;
    }

    public function check()  {
        $checkUrl = Str::replaceArray('??', [$this->secrect, $this->postValue], $this->url);
        $response = json_decode(file_get_contents($checkUrl));

        return $response;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

}
