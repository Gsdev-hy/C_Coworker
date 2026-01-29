<?php
// Point d'entrée de l'application

// 1. Inclusion de la config
require_once 'config/db.php';

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
        // TODO: Appeler AuthController->login()
        echo '<h2>Connexion (À implémenter)</h2>';
        break;

    default:
        echo '<div class="alert alert-danger">Page introuvable (404)</div>';
}

// 5. Footer commun
require_once 'views/layouts/footer.php';
