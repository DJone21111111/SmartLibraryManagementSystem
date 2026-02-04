<?php

namespace App\ViewModels;

class AdminLoansViewModel
{
    public string $title;
    public array $loans;

    public function __construct(string $title, array $loans)
    {
        $this->title = $title;
        $this->loans = $loans;
    }
}
