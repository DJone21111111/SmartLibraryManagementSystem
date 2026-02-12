<?php

namespace App\Repository;

interface IBookRepository
{
    public function getAll(string $search = '', string $filter = ''): array;

    public function findById(int $id): ?array;
    
    public function countAll(): int;

    public function countGenres(): int;
}
