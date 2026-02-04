<?php

namespace App\ViewModels;

class AdminReservationsViewModel
{
    public string $title;
    public array $reservations;

    public function __construct(string $title, array $reservations)
    {
        $this->title = $title;
        $this->reservations = $reservations;
    }
}
