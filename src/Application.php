<?php


namespace App;


class Application
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->initialize();
    }

    private function initialize()
    {
        $db = Config::getInstance()->get('db');

        $cfg = \ActiveRecord\Config::instance();
        $cfg->set_model_directory(MODEL_DIR);
        $cfg->set_connections(['development' => sprintf('mysql://%1$s:%2$s@%3$s/%4$s',
            $db['user'],
            $db['password'],
            $db['host'],
            $db['name']
        )]);
    }

    public function run()
    {
        try {
            $result = $this->router->dispatch();
            if (is_object($result) && $result instanceof Renderable) {
                $result->render();
            } else {
                echo (string) $result;
            }
        } catch (\Exception $e) {
            $this->renderException($e);
        }
    }

    private function renderException(\Exception $e)
    {
        if ($e instanceof Renderable) {
            $e->render();
        } else {
            echo 'Возникла ошибка номер ' . ($e->getCode() ?: 500) . ' с текстом: ' . $e->getMessage();
        }
    }
}