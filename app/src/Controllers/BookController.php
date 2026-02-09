<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Services\BookService;

class BookController extends Controller
{
    public function index(): void
    {
        $search = trim($_GET['q'] ?? '');

        try {
            $service = new BookService();
            $books = $service->getBooks($search);
        } catch (\Throwable $ex) {
            // Provide a friendly message instead of a blank page when DB is unavailable
            $this->flash('Unable to load catalog. Please ensure the database is running. (' . $ex->getMessage() . ')', 'danger');
            $books = [];
        }

        $this->render('Books/index', [
            'title' => 'Catalog',
            'books' => $books,
            'q' => $search
        ]);
    }

    public function detail(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            $this->redirect('catalog');
            return;
        }

        $service = new BookService();
        $book = $service->getBook($id);

        if (!$book) {
            $this->flash('Book not found.', 'danger');
            $this->redirect('catalog');
            return;
        }

        $this->render('Books/detail', [
            'title' => $book['Title'] ?? 'Book',
            'book' => $book
        ]);
    }
}
