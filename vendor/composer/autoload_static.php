<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb8c8eb5d01aa3087710e28964123bc65
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Faker\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb8c8eb5d01aa3087710e28964123bc65::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb8c8eb5d01aa3087710e28964123bc65::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb8c8eb5d01aa3087710e28964123bc65::$classMap;

        }, null, ClassLoader::class);
    }
}
