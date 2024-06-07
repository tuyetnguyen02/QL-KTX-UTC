<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit55f46d4f8cda82e4eadf46bfb4d604ec
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

        spl_autoload_register(array('ComposerAutoloaderInit55f46d4f8cda82e4eadf46bfb4d604ec', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit55f46d4f8cda82e4eadf46bfb4d604ec', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit55f46d4f8cda82e4eadf46bfb4d604ec::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
