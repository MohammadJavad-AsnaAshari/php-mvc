<?php

namespace Mj\PocketCore;

use Jenssegers\Blade\Blade;

class View
{
    protected Blade $blade;

    public function __construct()
    {
        $this->blade = new Blade(
            Application::$ROOT_DIR . 'resources/views',
            Application::$ROOT_DIR . "storage/cache/view"
        );
    }

    public function render(string $view, array $data): string
    {
        return $this->blade->render($view, $data);
    }
}