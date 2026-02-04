<?php

namespace App\Services;

use App\Repository\IUserRepository;
use App\Repository\UserRepository;

class AuthService implements IAuthService
{
    private IUserRepository $users;

    public function __construct(?IUserRepository $users = null)
    {
        $this->users = $users ?? new UserRepository();
    }

    public function login(string $email, string $password): ?array
    {
        $user = $this->users->findByEmail($email);

        if (!$user) {
            return null;
        }

        // Blocked user check
        if (!empty($user['is_blocked']) && (int)$user['is_blocked'] === 1) {
            return null;
        }

        // Password check (DB uses password_hash)
        if (!password_verify($password, $user['password_hash'])) {
            return null;
        }

        // Return safe user data to store in session (no password)
        return [
            'id' => (int)$user['id'],
            'email' => $user['Email'],
            'role' => $user['role']
        ];
    }
}
