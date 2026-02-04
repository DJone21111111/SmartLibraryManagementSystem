<?php

namespace App\Controllers;

use App\Framework\Auth;
use App\Framework\Controller;
use App\Services\LoanService;
use App\Services\ReservationService;

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $user = Auth::user();

        $loanService = new LoanService();
        $reservationService = new ReservationService();

        $this->render('MemberDashboard/dashboard', [
            'title' => 'Dashboard',
            'loans' => $loanService->getMyLoans((int)$user['id']),
            'reservations' => $reservationService->getMyReservations((int)$user['id'])
        ]);
    }
}
