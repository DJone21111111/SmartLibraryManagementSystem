<?php

namespace App\Framework;

class Controller
{
    public function __construct()
    {
        TempData::start();
    }

    protected function render(string $viewPath, array $data = []): void
    {
        $data['flash'] = TempData::get('flash');
        View::render($viewPath, $data);
    }

    protected function redirect(string $path): void
    {
        header("Location: " . $path);
        exit;
    }

    protected function flash(string $message, string $type = 'success'): void
    {
        TempData::set('flash', ['message' => $message, 'type' => $type]);
    }
}
