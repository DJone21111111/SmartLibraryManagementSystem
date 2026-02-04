<?php

namespace App\Services;

interface IReservationService
{
    public function getMyReservations(int $userId): array;

    public function reserve(int $userId, int $bookId): bool;
}
