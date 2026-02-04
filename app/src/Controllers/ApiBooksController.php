<?php

namespace App\Controllers;

use App\Services\BookService;

class ApiBooksController
{
    public function index(): void
    {
        $q = trim($_GET['q'] ?? '');

        $service = new BookService();
        $books = $service->getBooks($q);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($books);
    }
}
