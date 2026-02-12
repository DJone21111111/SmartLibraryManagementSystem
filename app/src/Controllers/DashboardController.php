<?php

namespace App\Controllers;

use App\Framework\Auth;
use App\Framework\Controller;
use App\Services\LoanService;
use App\Services\ReservationService;
use App\Services\BookService;

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $user = Auth::user();

        $search = trim($_GET['q'] ?? '');
        $filter = trim($_GET['filter'] ?? '');

        $loanService = new LoanService();
        $reservationService = new ReservationService();

        try {
            $bookService = new BookService();
            $books = $bookService->getBooks($search, $filter);
        } catch (\Throwable $ex) {
            $books = [];
            // keep friendly message via flash
            $this->flash('Unable to load catalog. Please ensure the database is running. (' . $ex->getMessage() . ')', 'danger');
        }

        $this->render('MemberDashboard/dashboard', [
            'title' => 'Dashboard',
            'loans' => $loanService->getMyLoans((int)$user['id']),
            'reservations' => $reservationService->getMyReservations((int)$user['id']),
            'books' => $books,
            'q' => $search,
            'filter' => $filter
        ]);
    }
}
