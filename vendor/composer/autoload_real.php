<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit993f0b76a458695bf8f9b13a96c1c743
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit993f0b76a458695bf8f9b13a96c1c743', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit993f0b76a458695bf8f9b13a96c1c743', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit993f0b76a458695bf8f9b13a96c1c743::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}