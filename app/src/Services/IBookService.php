<?php

namespace App\Services;

interface IBookService
{
    public function getBooks(string $search = '', string $filter = ''): array;

    public function getBook(int $id): ?array;
}
