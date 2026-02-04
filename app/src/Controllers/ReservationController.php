<?php

namespace App\Controllers;

use App\Framework\Auth;
use App\Framework\Controller;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    public function reserve(): void
    {
        Auth::requireLogin();

        $user = Auth::user();
        $bookId = (int)($_POST['book_id'] ?? 0);

        if ($bookId <= 0) {
            $this->flash('Invalid book.', 'danger');
            $this->redirect('catalog');
            return;
        }

        $service = new ReservationService();
        $ok = $service->reserve((int)$user['id'], $bookId);

        if (!$ok) {
            $this->flash('You already reserved this book.', 'warning');
            $this->redirect('book/detail&id=' . $bookId);
            return;
        }

        $this->flash('Reservation placed!', 'success');
        $this->redirect('dashboard');
    }
}
