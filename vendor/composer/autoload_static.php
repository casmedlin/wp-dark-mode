<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb79533e5ae4027775cbe47ea6279cb13
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPDM\\includes\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPDM\\includes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'WPDM\\includes\\WPPOOL_Settings_API' => __DIR__ . '/../..' . '/includes/class-settings-api.php',
        'WPDM\\includes\\WP_Dark_Mode_Enqueue' => __DIR__ . '/../..' . '/includes/class-enqueue.php',
        'WPDM\\includes\\WP_Dark_Mode_Hooks' => __DIR__ . '/../..' . '/includes/class-hooks.php',
        'WPDM\\includes\\WP_Dark_Mode_Install' => __DIR__ . '/../..' . '/includes/class-install.php',
        'WPDM\\includes\\WP_Dark_Mode_Settings' => __DIR__ . '/../..' . '/includes/class-settings.php',
        'WPDM\\includes\\WP_Dark_Mode_Shortcode' => __DIR__ . '/../..' . '/includes/class-shortcode.php',
        'WPDM\\includes\\WP_Dark_Mode_Theme_Supports' => __DIR__ . '/../..' . '/includes/class-theme-supports.php',
        'WPDM\\includes\\WP_Dark_Mode_Update' => __DIR__ . '/../..' . '/includes/class-update.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb79533e5ae4027775cbe47ea6279cb13::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb79533e5ae4027775cbe47ea6279cb13::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb79533e5ae4027775cbe47ea6279cb13::$classMap;

        }, null, ClassLoader::class);
    }
}
