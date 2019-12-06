<?php


namespace App;


final class Config // Singleton
{
    /*** @var Config */
    private static $instance;
    private $configs = [];

    private function __construct() {
        $this->configs['db'] = require(CONFIG_DIR . 'db.php');
    }

    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance(): Config
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function get(string $config, $default = null)
    {
        return array_get($this->configs, $config, $default);
    }
}

