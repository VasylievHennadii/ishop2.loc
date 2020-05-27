<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2222ab4e69e0ae53892d195ffb0ec6a9
{
    public static $prefixLengthsPsr4 = array (
        'i' => 
        array (
            'ishop\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ishop\\' => 
        array (
            0 => __DIR__ . '/..' . '/ishop/core',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2222ab4e69e0ae53892d195ffb0ec6a9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2222ab4e69e0ae53892d195ffb0ec6a9::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
