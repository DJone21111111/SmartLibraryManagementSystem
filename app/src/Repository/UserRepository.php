<?php

namespace App\Repository;

use App\Framework\BaseRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function findById(int $id): ?array
    {
        return $this->fetchOne(
            "SELECT id, role, Email, password_hash, is_blocked
             FROM users
             WHERE id = ?",
            [$id]
        );
    }

    public function findByEmail(string $email): ?array
    {
        return $this->fetchOne(
            "SELECT id, role, Email, password_hash, is_blocked
             FROM users
             WHERE Email = ?",
            [$email]
        );
    }
}
