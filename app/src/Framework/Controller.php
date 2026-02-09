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
        // Normalize redirects: accept absolute paths or route-like strings
        if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            $target = $path;
        } else {
            $target = '/' . ltrim($path, '/');
        }

        header("Location: " . $target);
        exit;
    }

    protected function flash(string $message, string $type = 'success'): void
    {
        TempData::set('flash', ['message' => $message, 'type' => $type]);
    }
}
