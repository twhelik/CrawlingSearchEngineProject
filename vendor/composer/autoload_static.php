<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd3519de11aa0ab08853daea69a34d3f1
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SearchEngine\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SearchEngine\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitd3519de11aa0ab08853daea69a34d3f1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd3519de11aa0ab08853daea69a34d3f1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd3519de11aa0ab08853daea69a34d3f1::$classMap;

        }, null, ClassLoader::class);
    }
}
