<?php

namespace App\Controllers;

use App\Framework\Auth;
use App\Services\LoanService;
use App\Services\ReservationService;

class ApiUserController
{
    public function dashboard(): void
    {
        Auth::requireLogin();

        $user = Auth::user();

        $loanService = new LoanService();
        $resService = new ReservationService();

        $data = [
            'loans' => $loanService->getMyLoans((int)$user['id']),
            'reservations' => $resService->getMyReservations((int)$user['id'])
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
}
