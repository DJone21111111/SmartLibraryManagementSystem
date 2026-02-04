<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Services\BookService;

class BookController extends Controller
{
    public function index(): void
    {
        $search = trim($_GET['q'] ?? '');

        $service = new BookService();
        $books = $service->getBooks($search);

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
