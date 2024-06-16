<?php

namespace App\Constants;

class AppConstants
{
    public const API_KEY = "1789123653195724";
    public const API_SECRET = "1c1247ef59ff19bc5422273b8fe5a766";
    public const PREFIX_DROPDOWN = "dropdown_";
    public const MASTER = [
        'prfix',
        'gender',
        'blood',
        'provinces',
        'religion',
        'nationality',
        'education',
        'marital_status',
    ];
    public static function prefix_image()
    {
        $imagePath = public_path("assets/images/");
        return $imagePath;
    }
    public static function prefix_pettion()
    {
        $imagePath = public_path("assets/pettions/");
        return $imagePath;
    }
}
