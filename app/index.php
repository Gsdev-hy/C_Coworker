<?php
// Configuration du fuseau horaire
date_default_timezone_set('Europe/Paris');

// Point d'entrée de l'application

// 1. Inclusion de la config et des fichiers essentiels
require_once 'config/db.php';
require_once 'models/Space.php';
require_once 'helpers/AuthHelper.php';

// 2. Gestion simple du routing
$page = $_GET['page'] ?? 'home';

// 3. Header commun
require_once 'views/layouts/header.php';

// 4. Contenu dynamique
switch ($page) {
    case 'home':
        echo '<div class="p-5 mb-4 bg-light rounded-3">';
        echo '<div class="container-fluid py-5">';
        echo '<h1 class="display-5 fw-bold">Bienvenue chez C\'Coworker</h1>';
        echo '<p class="col-md-8 fs-4">Gérez vos espaces de travail et vos salles de réunion en toute simplicité.</p>';
        echo '<a class="btn btn-primary btn-lg" href="index.php?page=spaces">Voir les espaces</a>';
        echo '</div>';
        echo '</div>';
        break;

    case 'dashboard':
        require_once 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'planning':
        require_once 'controllers/PlanningController.php';
        $controller = new PlanningController();
        $controller->index();
        break;

    case 'spaces':
        require_once 'controllers/SpaceController.php';
        $controller = new SpaceController();
        $controller->index();
        break;

    case 'spaces-create':
        require_once 'controllers/SpaceController.php';
        $controller = new SpaceController();
        $controller->create();
        break;

    case 'spaces-show':
        require_once 'controllers/SpaceController.php';
        $controller = new SpaceController();
        $controller->show();
        break;

    case 'spaces-edit':
        require_once 'controllers/SpaceController.php';
        $controller = new SpaceController();
        $controller->edit();
        break;

    case 'spaces-delete':
        require_once 'controllers/SpaceController.php';
        $controller = new SpaceController();
        $controller->delete();
        break;

    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'reservations':
        require_once 'controllers/ReservationController.php';
        $controller = new ReservationController();
        $controller->index();
        break;

    case 'reservations-create':
        require_once 'controllers/ReservationController.php';
        $controller = new ReservationController();
        $controller->create();
        break;

    case 'reservations-edit':
        require_once 'controllers/ReservationController.php';
        $controller = new ReservationController();
        $controller->edit();
        break;

    case 'reservations-delete':
        require_once 'controllers/ReservationController.php';
        $controller = new ReservationController();
        $controller->delete();
        break;

    default:
        echo '<div class="alert alert-danger">Page introuvable (404)</div>';
}

// 5. Footer commun
require_once 'views/layouts/footer.php';
