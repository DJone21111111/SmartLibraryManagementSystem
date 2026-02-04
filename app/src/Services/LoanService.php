<?php

namespace App\Services;

use App\Repository\BookCopyRepository;
use App\Repository\ILoanRepository;
use App\Repository\LoanRepository;

class LoanService implements ILoanService
{
    private ILoanRepository $loans;
    private BookCopyRepository $copies;

    public function __construct(
        ?ILoanRepository $loans = null,
        ?BookCopyRepository $copies = null
    ) {
        $this->loans = $loans ?? new LoanRepository();
        $this->copies = $copies ?? new BookCopyRepository();
    }

    public function getMyLoans(int $userId): array
    {
        return $this->loans->getActiveByUser($userId);
    }

    public function returnBook(int $loanId, int $userId): bool
    {
        return $this->loans->returnLoan($loanId, $userId);
    }

    public function borrow(int $userId, int $bookId): bool
    {
        // Find an available copy of this book
        $copyId = $this->copies->findAvailableCopyId($bookId);

        if ($copyId === null) {
            return false; // no copies available
        }

        // Simple rule: 14 days loan
        $dueAt = date('Y-m-d H:i:s', strtotime('+14 days'));

        $newLoanId = $this->loans->create($userId, $copyId, $dueAt);

        return $newLoanId > 0;
    }
}
