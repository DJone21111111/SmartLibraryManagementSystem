<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use App\Repository\LoanRepository;
use App\Repository\ReservationRepository;

class HomeController extends Controller
{
    public function index(): void
    {
        $bookRepo = new BookRepository();
        $userRepo = new UserRepository();
        $loanRepo = new LoanRepository();
        $reservationRepo = new ReservationRepository();

        $stats = [
            [number_format($bookRepo->countAll()), 'Books'],
            [number_format($bookRepo->countAvailable()), 'Available'],
            [number_format($loanRepo->countActiveAll()), 'Active Loans'],
            [number_format($userRepo->countMembers()), 'Members']
        ];

        $this->render('Home/index', [
            'title' => 'Home',
            'stats' => $stats
        ]);
    }
}
