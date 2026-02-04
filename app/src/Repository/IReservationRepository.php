<?php

namespace App\Repository;

interface IReservationRepository
{
    public function create(int $bookId, int $userId, string $status): int;

    public function getByUser(int $userId): array;

    public function hasActiveReservation(int $userId, int $bookId): bool;
}
