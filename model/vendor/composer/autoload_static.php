<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6d2863d5173dcc67b5162a89b66e5743
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'eMarket\\' => 8,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'eMarket\\' => 
        array (
            0 => __DIR__ . '/../..' . '/eMarket',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/league/color-extractor/src',
    );

    public static $prefixesPsr0 = array (
        'c' => 
        array (
            'claviska' => 
            array (
                0 => __DIR__ . '/..' . '/claviska/simpleimage/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FileUpload' => __DIR__ . '/..' . '/lpology/uploader/uploader.php',
        'UploadHandler' => __DIR__ . '/..' . '/blueimp/fileupload/UploadHandler.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6d2863d5173dcc67b5162a89b66e5743::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6d2863d5173dcc67b5162a89b66e5743::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit6d2863d5173dcc67b5162a89b66e5743::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit6d2863d5173dcc67b5162a89b66e5743::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit6d2863d5173dcc67b5162a89b66e5743::$classMap;

        }, null, ClassLoader::class);
    }
}
