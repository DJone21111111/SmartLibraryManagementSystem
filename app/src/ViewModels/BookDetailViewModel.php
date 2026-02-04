<?php

namespace App\ViewModels;

class BookDetailViewModel
{
    public string $title;
    public array $book;

    public bool $isLoggedIn;
    public string $userRole;

    public function __construct(string $title, array $book, bool $isLoggedIn, string $userRole = '')
    {
        $this->title = $title;
        $this->book = $book;
        $this->isLoggedIn = $isLoggedIn;
        $this->userRole = $userRole;
    }
}
