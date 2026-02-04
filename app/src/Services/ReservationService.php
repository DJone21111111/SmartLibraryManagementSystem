<?php

namespace App\Services;

use App\Enum\ReservationStatus;
use App\Repository\IReservationRepository;
use App\Repository\ReservationRepository;

class ReservationService implements IReservationService
{
    private IReservationRepository $reservations;

    public function __construct(?IReservationRepository $reservations = null)
    {
        $this->reservations = $reservations ?? new ReservationRepository();
    }

    public function getMyReservations(int $userId): array
    {
        return $this->reservations->getByUser($userId);
    }

    public function reserve(int $userId, int $bookId): bool
    {
        if ($this->reservations->hasActiveReservation($userId, $bookId)) {
            return false;
        }

        $newId = $this->reservations->create(
            $bookId,
            $userId,
            ReservationStatus::PENDING->value
        );

        return $newId > 0;
    }
}
