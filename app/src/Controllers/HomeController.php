<?php

namespace App\Controllers;

use App\Framework\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('Home/index', [
            'title' => 'Home'
        ]);
    }
}
