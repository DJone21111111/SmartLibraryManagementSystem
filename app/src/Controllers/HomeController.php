<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Repository\BookRepository;
use App\Repository\UserRepository;

class HomeController extends Controller
{
    public function index(): void
    {
        $bookRepo = new BookRepository();
        $userRepo = new UserRepository();

        $stats = [
            [number_format($bookRepo->countAll()), 'Books'],
            [number_format($bookRepo->countGenres()), 'Genres'],
            [number_format($userRepo->countMembers()), 'Members'],
            ['Online', 'Online']
        ];

        $this->render('Home/index', [
            'title' => 'Home',
            'stats' => $stats
        ]);
    }
}
