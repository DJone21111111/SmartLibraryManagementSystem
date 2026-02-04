<?php

namespace App\Repository;

use App\Framework\BaseRepository;

class BookCopyRepository extends BaseRepository
{
    public function findAvailableCopyId(int $bookId): ?int
    {
        $row = $this->fetchOne(
            "SELECT bc.id
             FROM book_copies bc
             LEFT JOIN loans l
               ON l.copy_id = bc.id AND l.returned_at IS NULL
             WHERE bc.book_id = ?
               AND l.id IS NULL
             LIMIT 1",
            [$bookId]
        );

        return $row ? (int)$row['id'] : null;
    }
}
