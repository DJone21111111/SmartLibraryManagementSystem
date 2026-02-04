<?php

namespace App\Repository;

interface ILoanRepository
{
    public function getActiveByUser(int $userId): array;

    public function returnLoan(int $loanId, int $userId): bool;
}
