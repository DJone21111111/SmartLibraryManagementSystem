<?php

namespace App\Services;

interface IBookService
{
    public function getBooks(string $search = ''): array;

    public function getBook(int $id): ?array;
}
