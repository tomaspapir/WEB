<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit73d6cdb19ac548c880e53bc3f618019d
{
    public static $prefixesPsr0 = array (
        'A' => 
        array (
            'AlexanderMatveev\\PopperBundle' => 
            array (
                0 => __DIR__ . '/..' . '/alexandermatveev/popper-bundle',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit73d6cdb19ac548c880e53bc3f618019d::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
