<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Services\BookService;

class BookController extends Controller
{
    public function index(): void
    {
        $search = trim($_GET['q'] ?? '');
        $filter = trim($_GET['filter'] ?? '');

        try {
            // If asking for user-specific lists (overdue/reserved) and user is logged in,
            // fetch via repositories so we can return only items for that user.
            $service = new BookService();
            if ($filter === 'overdue' && \App\Framework\Auth::check()) {
                $user = \App\Framework\Auth::user();
                $lr = new \App\Repository\LoanRepository();
                $loans = $lr->getActiveByUser((int)$user['id']);
                // keep only overdue loans
                $now = new \DateTimeImmutable();
                $books = [];
                foreach ($loans as $l) {
                    $due = isset($l['due_at']) ? new \DateTimeImmutable($l['due_at']) : null;
                    if ($due !== null && $due < $now) {
                        $books[] = [
                            'id' => $l['book_id'] ?? $l['bookId'] ?? $l['id'] ?? null,
                            'Title' => $l['Title'] ?? '',
                            'author' => $l['author'] ?? '',
                            'cover_url' => $l['cover_url'] ?? '',
                            'available' => 0,
                            'total_copies' => 1
                        ];
                    }
                }
            } elseif ($filter === 'reserved' && \App\Framework\Auth::check()) {
                $user = \App\Framework\Auth::user();
                $rr = new \App\Repository\ReservationRepository();
                $res = $rr->getByUser((int)$user['id']);
                $books = [];
                foreach ($res as $r) {
                    $books[] = [
                        'id' => $r['book_id'] ?? $r['bookId'] ?? $r['id'] ?? null,
                        'Title' => $r['Title'] ?? '',
                        'author' => $r['author'] ?? '',
                        'cover_url' => $r['cover_url'] ?? '',
                        'available' => 0,
                        'total_copies' => 1
                    ];
                }
            } else {
                $books = $service->getBooks($search, $filter);
            }
        } catch (\Throwable $ex) {
            // Provide a friendly message instead of a blank page when DB is unavailable
            $this->flash('Unable to load catalog. Please ensure the database is running. (' . $ex->getMessage() . ')', 'danger');
            $books = [];
        }

        $this->render('Books/index', [
            'title' => 'Catalog',
            'books' => $books,
            'q' => $search,
            'filter' => $filter
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
