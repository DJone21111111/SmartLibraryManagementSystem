<?php

namespace App\ViewModels;

class CatalogViewModel
{
    public string $title;
    public string $search;
    public array $books;

    public function __construct(string $title, string $search, array $books)
    {
        $this->title = $title;
        $this->search = $search;
        $this->books = $books;
    }
}
