<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit688665fe125e2ec16d09c02a32877388
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit688665fe125e2ec16d09c02a32877388::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit688665fe125e2ec16d09c02a32877388::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit688665fe125e2ec16d09c02a32877388::$classMap;

        }, null, ClassLoader::class);
    }
}
