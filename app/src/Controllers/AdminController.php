<?php

namespace App\Controllers;

use App\Framework\Auth;
use App\Framework\Controller;
use App\Services\BookService;

class AdminController extends Controller
{
    public function dashboard(): void
    {
        Auth::requireLibrarian();

        $this->render('Admin/dashboard', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function books(): void
    {
        Auth::requireLibrarian();

        $search = trim($_GET['q'] ?? '');

        $service = new BookService();
        $books = $service->getBooks($search);

        $this->render('Admin/books/index', [
            'title' => 'Manage Books',
            'books' => $books,
            'q' => $search
        ]);
    }
}
