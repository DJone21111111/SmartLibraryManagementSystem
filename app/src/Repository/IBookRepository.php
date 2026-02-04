<?php

namespace App\Repository;

interface IBookRepository
{
    public function getAll(string $search = ''): array;

    public function findById(int $id): ?array;
}
