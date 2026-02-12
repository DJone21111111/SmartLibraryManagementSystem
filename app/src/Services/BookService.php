<?php

namespace App\Services;

use App\Repository\BookRepository;
use App\Repository\IBookRepository;

class BookService implements IBookService
{
    private IBookRepository $books;

    public function __construct(?IBookRepository $books = null)
    {
        $this->books = $books ?? new BookRepository();
    }

    public function getBooks(string $search = '', string $filter = ''): array
    {
        return $this->books->getAll($search, $filter);
    }

    public function getBook(int $id): ?array
    {
        return $this->books->findById($id);
    }
}
