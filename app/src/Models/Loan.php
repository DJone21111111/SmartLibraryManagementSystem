<?php

namespace App\Models;

class Loan
{
    public int $id;
    public int $user_id;
    public int $copy_id;
    public ?string $loaned_at;
    public ?string $due_at;
    public ?string $returned_at;
    public int $renew_count;
    public float $fine_amount;

    public static function fromArray(array $row): Loan
    {
        $l = new Loan();

        $l->id = (int)($row['id'] ?? 0);
        $l->user_id = (int)($row['user_id'] ?? 0);
        $l->copy_id = (int)($row['copy_id'] ?? 0);

        $l->loaned_at = $row['loaned_at'] ?? null;
        $l->due_at = $row['due_at'] ?? null;
        $l->returned_at = $row['returned_at'] ?? null;

        $l->renew_count = (int)($row['renew_count'] ?? 0);
        $l->fine_amount = (float)($row['fine_amount'] ?? 0);

        return $l;
    }
}
