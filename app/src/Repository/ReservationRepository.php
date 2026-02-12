<?php

namespace App\Repository;

use App\Enum\ReservationStatus;
use App\Framework\BaseRepository;

class ReservationRepository extends BaseRepository implements IReservationRepository
{
    public function create(int $bookId, int $userId, string $status): int
    {
        $ok = $this->execute(
            "INSERT INTO reservations (book_id, user_id, Status, created_at)
             VALUES (?, ?, ?, NOW())",
            [$bookId, $userId, $status]
        );

        if (!$ok) {
            try {
                error_log(sprintf('[ReservationRepository::create] INSERT failed for user=%d book=%d status=%s', $userId, $bookId, $status));
            } catch (\Throwable $_) {}
        } else {
            try {
                error_log('[ReservationRepository::create] Inserted id=' . $this->lastInsertId());
            } catch (\Throwable $_) {}
        }

        return $this->lastInsertId();
    }

    public function getByUser(int $userId): array
    {
        return $this->fetchAll(
            "SELECT r.*, b.Title, b.author, b.cover_url
             FROM reservations r
             JOIN books b ON b.id = r.book_id
             WHERE r.user_id = ?
               AND r.Status IN (?, ?)
             ORDER BY r.created_at DESC",
            [
                $userId,
                ReservationStatus::PENDING->value,
                ReservationStatus::APPROVED->value
            ]
        );
    }

    public function hasActiveReservation(int $userId, int $bookId): bool
    {
        $row = $this->fetchOne(
            "SELECT id
             FROM reservations
             WHERE user_id = ?
               AND book_id = ?
               AND Status IN ('waiting','ready')
             LIMIT 1",
            [$userId, $bookId]
        );

        return $row !== null;
    }

    public function cancel(int $reservationId, int $userId): bool
    {
        return $this->execute(
            "UPDATE reservations SET Status = ? WHERE id = ? AND user_id = ?",
            [ReservationStatus::CANCELED->value, $reservationId, $userId]
        );
    }

    public function countActiveAll(): int
    {
        $row = $this->fetchOne("SELECT COUNT(*) as cnt FROM reservations WHERE Status IN ('waiting','ready')");
        return (int)($row['cnt'] ?? 0);
    }

}
