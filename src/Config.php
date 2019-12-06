<?php


namespace App;


final class Config // Singleton
{
    /*** @var Config */
    private static $instance;
    private $configs = [];

    private function __construct()
    {
        foreach (glob(CONFIG_DIR . '/*.php') as $path) {
            $this->configs[pathinfo($path, PATHINFO_FILENAME)] = require($path);
        }
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

    public function get(string $request, $default = null)
    {
        return array_get($this->configs, $request, $default);
    }

    public function set(string $config, $value)
    {
        $array = explode('.', $config);

        for ($i = count($array) - 1; $i > 0; --$i) {
            $value = [$array[$i] => $value];
        }
        $config = array_merge($this->configs[$array[0]] ?? [], $value);
        $this->configs[$array[0]] = $config;

        $content = '<?php' . PHP_EOL . PHP_EOL . 'return ' . var_export($config, true) . ';' . PHP_EOL;

        file_put_contents(CONFIG_DIR . '/' . $array[0] . '.php', $content);
    }
}
