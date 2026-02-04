<?php

namespace App\Models;

class User
{
    public int $id;
    public string $role;
    public string $Email;
    public string $password_hash;
    public int $is_blocked;
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $row): User
    {
        $u = new User();

        $u->id = (int)($row['id'] ?? 0);
        $u->role = (string)($row['role'] ?? 'member');
        $u->Email = (string)($row['Email'] ?? '');
        $u->password_hash = (string)($row['password_hash'] ?? '');
        $u->is_blocked = (int)($row['is_blocked'] ?? 0);
        $u->created_at = $row['created_at'] ?? null;
        $u->updated_at = $row['updated_at'] ?? null;

        return $u;
    }
}
