<?php

namespace App\ViewModels;

class MemberDashboardViewModel
{
    public string $title;
    public array $loans;
    public array $reservations;

    public function __construct(string $title, array $loans, array $reservations)
    {
        $this->title = $title;
        $this->loans = $loans;
        $this->reservations = $reservations;
    }
}
