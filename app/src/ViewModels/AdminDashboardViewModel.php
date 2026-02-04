<?php

namespace App\ViewModels;

class AdminDashboardViewModel
{
    public string $title;

    public int $totalBooks;
    public int $activeLoans;
    public int $totalReservations;

    public function __construct(string $title, int $totalBooks, int $activeLoans, int $totalReservations)
    {
        $this->title = $title;
        $this->totalBooks = $totalBooks;
        $this->activeLoans = $activeLoans;
        $this->totalReservations = $totalReservations;
    }
}
