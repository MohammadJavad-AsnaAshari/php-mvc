<?php

namespace Mj\PocketCore;

use Jenssegers\Blade\Blade;
use Rakit\Validation\ErrorBag;

class View
{
    protected Blade $blade;

    public function __construct()
    {
        $this->blade = new Blade(
            Application::$ROOT_DIR . 'resources/views',
            Application::$ROOT_DIR . "storage/cache/views"
        );

        $this->blade->share('errors', session()->flash('errors') ?? new ErrorBag());
        $this->blade->share('old', function ($key) {
            $inputs = session()->flash('old_inputs') ?? [];

            return $inputs[$key] ?? "";
        });
    }

    public function render(string $view, array $data = []): string
    {
        return $this->blade->render($view, $data);
    }
}