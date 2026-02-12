<?php

require __DIR__ . '/../vendor/autoload.php';

\App\Framework\TempData::start();

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use App\Controllers\AuthController;
use App\Controllers\BookController;
use App\Controllers\HomeController;
use App\Controllers\LoanController;
use App\Controllers\ReservationController;
use App\Controllers\DashboardController;
use App\Framework\Auth;
use App\Services\LoanService;
use App\Services\ReservationService;

function render(string $viewPath, array $vars = []): void {
    \App\Framework\TempData::start();
    $vars['flash'] = \App\Framework\TempData::get('flash');
    extract($vars, EXTR_SKIP);

    $baseViews = __DIR__ . '/../src/Views';
    // Support both styles: framework view paths (e.g. 'Books/index')
    // and legacy file paths with extension (e.g. 'Auth/login.php').
    if (str_ends_with($viewPath, '.php')) {
        $full = $baseViews . '/' . ltrim($viewPath, '/');

        if (!is_file($full)) {
            http_response_code(500);
            echo "View not found: " . htmlspecialchars($viewPath);
            return;
        }

        require $baseViews . '/Shared/header.php';
        require $baseViews . '/Shared/navbar.php';
        require $full;
        require $baseViews . '/Shared/footer.php';
        return;
    }

    // Delegate to framework View renderer for normalized view paths.
    \App\Framework\View::render($viewPath, $vars);
}

$dispatcher = simpleDispatcher(function (RouteCollector $r) {

    // Home: send logged-in users to dashboard, guests to catalog
    $r->addRoute('GET', '/', function() {
        if (\App\Framework\Auth::check()) {
            (new DashboardController())->index();
            return;
        }

        (new BookController())->index();
    });
    $r->addRoute('GET', '/index.php', function() { (new HomeController())->index(); }); // fixes /index.php 404
    // Support POSTs to /index.php?route=... for environments without URL rewriting
    $r->addRoute('POST', '/index.php', function() {
        $route = trim($_GET['route'] ?? '');
        try { error_log('[index.php legacy POST] route=' . $route . ' REQUEST_URI=' . ($_SERVER['REQUEST_URI'] ?? '') . ' POST=' . json_encode($_POST)); } catch (\Throwable $_) {}
        switch ($route) {
            case 'reserve':
                (new ReservationController())->reserve();
                break;
            case 'reserve/cancel':
                (new ReservationController())->cancel();
                break;
            case 'loan/borrow':
                (new LoanController())->borrow();
                break;
            case 'loan/return':
                (new LoanController())->returnBook();
                break;
            default:
                http_response_code(404);
                echo '404 - Page Not Found';
                break;
        }
    });

    // Catalog (Books) -> controller-backed
    $r->addRoute('GET', '/catalog', function() { (new BookController())->index(); });
    $r->addRoute('GET', '/books', function() { (new BookController())->index(); });
    $r->addRoute('GET', '/books/{id:\\d+}', function($vars) { $_GET['id'] = $vars['id']; (new BookController())->detail(); });

    // Auth (GET and POST)
    $r->addRoute('GET', '/login', function() { (new AuthController())->loginForm(); });
    $r->addRoute('POST', '/login', function() { (new AuthController())->loginPost(); });
    // Forgot password (simple placeholder to avoid 404)
    $r->addRoute('GET', '/forgot-password', function() { render('Auth/forgot-password.php'); });
    $r->addRoute('POST', '/forgot-password', function() {
        // simple handler: accept email and redirect back to login with flash
        $email = trim($_POST['email'] ?? '');
        if ($email !== '') {
            \App\Framework\TempData::start();
            \App\Framework\TempData::set('flash', ['message' => 'If that email exists we sent reset instructions (demo).', 'type' => 'success']);
        }
        header('Location: /login');
        exit;
    });
    // Register is a simple view (no controller methods currently implemented)
    $r->addRoute('GET', '/register', function() { render('Auth/register.php'); });
    $r->addRoute('POST', '/register', function() {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $password2 = trim($_POST['password2'] ?? '');

        if ($name === '' || $email === '' || $password === '' || $password2 === '') {
            \App\Framework\TempData::start();
            \App\Framework\TempData::set('flash', ['message' => 'All fields are required.', 'type' => 'danger']);
            header('Location: /register');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            \App\Framework\TempData::start();
            \App\Framework\TempData::set('flash', ['message' => 'Invalid email address.', 'type' => 'danger']);
            header('Location: /register');
            exit;
        }

        if ($password !== $password2) {
            \App\Framework\TempData::start();
            \App\Framework\TempData::set('flash', ['message' => 'Passwords do not match.', 'type' => 'danger']);
            header('Location: /register');
            exit;
        }

        $pdo = \App\Framework\Database::pdo();
        // check existing
        $stmt = $pdo->prepare('SELECT id FROM users WHERE Email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            \App\Framework\TempData::start();
            \App\Framework\TempData::set('flash', ['message' => 'An account with that email already exists.', 'type' => 'danger']);
            header('Location: /register');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $ins = $pdo->prepare('INSERT INTO users (role, name, Email, password_hash, is_blocked, created_at, updated_at) VALUES (?, ?, ?, ?, 0, NOW(), NOW())');
        $ok = $ins->execute(['member', $name, $email, $hash]);

        \App\Framework\TempData::start();
        if ($ok) {
            \App\Framework\TempData::set('flash', ['message' => 'Account created. Please login.', 'type' => 'success']);
        } else {
            \App\Framework\TempData::set('flash', ['message' => 'Registration failed. Please try again.', 'type' => 'danger']);
        }

        header('Location: /login');
        exit;
    });
    $r->addRoute('GET', '/logout', function() { (new AuthController())->logout(); });

    // Loan & Reservation POST handlers
    $r->addRoute('POST', '/loan/borrow', function() { (new LoanController())->borrow(); });
    $r->addRoute('POST', '/loan/return', function() { (new LoanController())->returnBook(); });
    $r->addRoute('POST', '/reserve', function() { (new ReservationController())->reserve(); });
    $r->addRoute('POST', '/reserve/cancel', function() { (new ReservationController())->cancel(); });

    // Member dashboard (require login)
    $r->addRoute('GET', '/dashboard', function() { (new DashboardController())->index(); });
    $r->addRoute('GET', '/dashboard/loans', function() {
        Auth::requireLogin();
        $user = Auth::user();
        $ls = new LoanService();
        render('MemberDashboard/loans.php', ['loans' => $ls->getMyLoans((int)$user['id'])]);
    });
    $r->addRoute('GET', '/dashboard/reservation', function() {
        Auth::requireLogin();
        $user = Auth::user();
        $rs = new ReservationService();
        render('MemberDashboard/reservation.php', ['reservations' => $rs->getMyReservations((int)$user['id'])]);
    });

    // Legacy/shortcut routes for navbar links
    $r->addRoute('GET', '/loans', function() {
        Auth::requireLogin();
        $user = Auth::user();
        $ls = new LoanService();
        render('MemberDashboard/loans.php', ['loans' => $ls->getMyLoans((int)$user['id'])]);
    });
    $r->addRoute('GET', '/reservations', function() {
        Auth::requireLogin();
        $user = Auth::user();
        $rs = new ReservationService();
        render('MemberDashboard/reservation.php', ['reservations' => $rs->getMyReservations((int)$user['id'])]);
    });
    $r->addRoute('GET', '/settings', function() { Auth::requireLogin(); render('MemberDashboard/settings.php'); });

    // Admin
    $r->addRoute('GET', '/admin/dashboard', function() { render('Admin/dashboard.php'); });
    $r->addRoute('GET', '/admin/books', function() { render('Admin/books/index.php'); });
    $r->addRoute('GET', '/admin/books/create', function() { render('Admin/books/create.php'); });
    $r->addRoute('GET', '/admin/books/edit', function() { render('Admin/books/edit.php'); });

    $r->addRoute('GET', '/admin/loans', function() { render('Admin/loans/index.php'); });
    $r->addRoute('GET', '/admin/reservation', function() { render('Admin/reservation/index.php'); });

});

$httpMethod = $_SERVER['REQUEST_METHOD'];

// Legacy support: if an old query-style route is used (index.php?route=...),
// translate it into the modern path form so old views keep working.
$uri = strtok($_SERVER['REQUEST_URI'], '?');
if (isset($_GET['route'])) {
    $legacy = trim($_GET['route'], '/');
    // map a few common legacy routes to new paths
    if ($legacy === 'home') {
        $uri = '/';
    } elseif ($legacy === 'catalog') {
        $uri = '/catalog';
    } elseif ($legacy === 'login') {
        $uri = '/login';
    } elseif ($legacy === 'register') {
        $uri = '/register';
    } elseif ($legacy === 'dashboard') {
        $uri = '/dashboard';
    } elseif ($legacy === 'admin/dashboard') {
        $uri = '/admin/dashboard';
    } elseif ($legacy === 'admin/books') {
        $uri = '/admin/books';
    } elseif ($legacy === 'book/detail' && isset($_GET['id'])) {
        $uri = '/books/' . (int)$_GET['id'];
    } elseif ($legacy === 'book/detail' && isset($_GET['book_id'])) {
        $uri = '/books/' . (int)$_GET['book_id'];
    } elseif ($legacy === 'catalog' && isset($_GET['q'])) {
        $uri = '/catalog';
    } else {
        // fallback: prepend slash and use route string
        $uri = '/' . $legacy;
    }
}


$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo "405 - Method Not Allowed";
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2] ?? [];
        echo $handler($vars);
        break;
}
