<?php

namespace App\Repository;

interface IUserRepository
{
    public function findById(int $id): ?array;

    public function findByEmail(string $email): ?array;
}
