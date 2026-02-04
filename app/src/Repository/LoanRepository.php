<?php

namespace App\Repository;

use App\Framework\BaseRepository;

class LoanRepository extends BaseRepository implements ILoanRepository
{
    public function getActiveByUser(int $userId): array
    {
        return $this->fetchAll(
            "SELECT l.*, b.Title, b.author, b.cover_url
             FROM loans l
             JOIN book_copies bc ON bc.id = l.copy_id
             JOIN books b ON b.id = bc.book_id
             WHERE l.user_id = ?
               AND l.returned_at IS NULL
             ORDER BY l.loaned_at DESC",
            [$userId]
        );
    }

    public function returnLoan(int $loanId, int $userId): bool
    {
        return $this->execute(
            "UPDATE loans
             SET returned_at = NOW()
             WHERE id = ? AND user_id = ?",
            [$loanId, $userId]
        );
    }

    public function create(int $userId, int $copyId, string $dueAt): int
{
    $this->execute(
        "INSERT INTO loans (user_id, copy_id, loaned_at, due_at, returned_at, renew_count, fine_amount)
         VALUES (?, ?, NOW(), ?, NULL, 0, 0.00)",
        [$userId, $copyId, $dueAt]
    );

    return $this->lastInsertId();
}

}
