<?php

namespace App\Services;

interface ILoanService
{
    public function getMyLoans(int $userId): array;

    public function returnBook(int $loanId, int $userId): bool;

    public function borrow(int $userId, int $bookId): bool;
}
