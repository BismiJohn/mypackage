<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite31a45572aaeeee7c84de45a4ac98428
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bismijohn\\Mypackage\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bismijohn\\Mypackage\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInite31a45572aaeeee7c84de45a4ac98428::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite31a45572aaeeee7c84de45a4ac98428::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite31a45572aaeeee7c84de45a4ac98428::$classMap;

        }, null, ClassLoader::class);
    }
}
