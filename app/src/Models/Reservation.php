<?php

namespace App\Models;

class Reservation
{
    public int $id;
    public int $book_id;
    public int $user_id;
    public string $Status;
    public ?string $created_at;
    public ?string $ready_at;
    public ?string $expires_at;

    public static function fromArray(array $row): Reservation
    {
        $r = new Reservation();

        $r->id = (int)($row['id'] ?? 0);
        $r->book_id = (int)($row['book_id'] ?? 0);
        $r->user_id = (int)($row['user_id'] ?? 0);
        $r->Status = (string)($row['Status'] ?? \App\Enum\ReservationStatus::PENDING->value);
        $r->created_at = $row['created_at'] ?? null;
        $r->ready_at = $row['ready_at'] ?? null;
        $r->expires_at = $row['expires_at'] ?? null;

        return $r;
    }
}
