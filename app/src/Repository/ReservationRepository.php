<?php

namespace App\Repository;

use App\Framework\BaseRepository;

class ReservationRepository extends BaseRepository implements IReservationRepository
{
    public function create(int $bookId, int $userId, string $status): int
    {
        $this->execute(
            "INSERT INTO reservations (book_id, user_id, Status, created_at)
             VALUES (?, ?, ?, NOW())",
            [$bookId, $userId, $status]
        );

        return $this->lastInsertId();
    }

    public function getByUser(int $userId): array
    {
        return $this->fetchAll(
            "SELECT r.*, b.Title, b.author, b.cover_url
             FROM reservations r
             JOIN books b ON b.id = r.book_id
             WHERE r.user_id = ?
             ORDER BY r.created_at DESC",
            [$userId]
        );
    }

    public function hasActiveReservation(int $userId, int $bookId): bool
{
    $row = $this->fetchOne(
        "SELECT id
         FROM reservations
         WHERE user_id = ?
           AND book_id = ?
           AND Status IN ('pending','ready')
         LIMIT 1",
        [$userId, $bookId]
    );

    return $row !== null;
}

}
