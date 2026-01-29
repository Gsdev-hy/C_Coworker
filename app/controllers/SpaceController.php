<?php
/**
 * Contrôleur Space
 * Gestion des actions liées aux espaces
 */

// Inclusion du modèle
require_once __DIR__ . '/../models/Space.php';

class SpaceController
{

    /**
     * Action : Liste de tous les espaces
     * Route : ?page=spaces
     */
    public function index()
    {
        // Récupération de tous les espaces depuis le modèle
        $spaces = Space::findAll();

        // Inclusion de la vue
        require_once __DIR__ . '/../views/spaces/index.php';
    }
}
