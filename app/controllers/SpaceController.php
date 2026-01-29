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

    /**
     * Action : Afficher le formulaire de création / Traiter la soumission
     * Route : ?page=spaces-create
     */
    public function create()
    {
        // Initialisation des variables pour la vue
        $errors = [];
        $success = false;

        // Traitement du formulaire si POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et nettoyage des données
            $data = [
                'name' => $_POST['name'] ?? '',
                'capacity' => $_POST['capacity'] ?? '',
                'type' => $_POST['type'] ?? '',
                'equipment' => $_POST['equipment'] ?? ''
            ];

            // Validation côté serveur
            if (empty($data['name'])) {
                $errors[] = "Le nom de l'espace est obligatoire.";
            }

            if (empty($data['capacity']) || !is_numeric($data['capacity']) || $data['capacity'] <= 0) {
                $errors[] = "La capacité doit être un nombre supérieur à 0.";
            }

            if (empty($data['type']) || !in_array($data['type'], ['bureau', 'reunion', 'open-space'])) {
                $errors[] = "Le type d'espace est invalide.";
            }

            // Si pas d'erreurs, créer l'espace
            if (empty($errors)) {
                $spaceId = Space::create($data);

                if ($spaceId) {
                    // Démarrer la session si pas déjà fait
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    // Message flash de succès
                    $_SESSION['flash_success'] = "L'espace \"{$data['name']}\" a été créé avec succès.";

                    // Redirection vers la liste
                    header('Location: index.php?page=spaces');
                    exit;
                } else {
                    $errors[] = "Une erreur est survenue lors de la création de l'espace.";
                }
            }
        }

        // Affichage du formulaire
        require_once __DIR__ . '/../views/spaces/create.php';
    }

    /**
     * Action : Afficher les détails d'un espace
     * Route : ?page=spaces-show&id=X
     */
    public function show()
    {
        // Récupération et validation de l'ID
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id) || $id <= 0) {
            // ID invalide : afficher une erreur
            $error = "Identifiant d'espace invalide.";
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        // Récupération de l'espace
        $space = Space::findById($id);

        if (!$space) {
            // Espace non trouvé
            $error = "L'espace demandé n'existe pas.";
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        // Affichage de la vue détail
        require_once __DIR__ . '/../views/spaces/show.php';
    }

    /**
     * Action : Afficher le formulaire de modification / Traiter la soumission
     * Route : ?page=spaces-edit&id=X
     */
    public function edit()
    {
        // Récupération et validation de l'ID
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id) || $id <= 0) {
            $error = "Identifiant d'espace invalide.";
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        // Récupération de l'espace existant
        $space = Space::findById($id);

        if (!$space) {
            $error = "L'espace demandé n'existe pas.";
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        // Initialisation des variables pour la vue
        $errors = [];

        // Traitement du formulaire si POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et nettoyage des données
            $data = [
                'name' => $_POST['name'] ?? '',
                'capacity' => $_POST['capacity'] ?? '',
                'type' => $_POST['type'] ?? '',
                'equipment' => $_POST['equipment'] ?? ''
            ];

            // Validation côté serveur
            if (empty($data['name'])) {
                $errors[] = "Le nom de l'espace est obligatoire.";
            }

            if (empty($data['capacity']) || !is_numeric($data['capacity']) || $data['capacity'] <= 0) {
                $errors[] = "La capacité doit être un nombre supérieur à 0.";
            }

            if (empty($data['type']) || !in_array($data['type'], ['bureau', 'reunion', 'open-space'])) {
                $errors[] = "Le type d'espace est invalide.";
            }

            // Si pas d'erreurs, mettre à jour l'espace
            if (empty($errors)) {
                $success = Space::update($id, $data);

                if ($success) {
                    // Démarrer la session si pas déjà fait
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    // Message flash de succès
                    $_SESSION['flash_success'] = "L'espace \"{$data['name']}\" a été modifié avec succès.";

                    // Redirection vers la page détail
                    header("Location: index.php?page=spaces-show&id=$id");
                    exit;
                } else {
                    $errors[] = "Une erreur est survenue lors de la modification de l'espace.";
                }
            }

            // En cas d'erreur, mettre à jour $space avec les données soumises pour les réafficher
            $space = array_merge($space, $data);
        }

        // Affichage du formulaire
        require_once __DIR__ . '/../views/spaces/edit.php';
    }

    /**
     * Action : Afficher la page de confirmation de suppression / Traiter la suppression
     * Route : ?page=spaces-delete&id=X
     */
    public function delete()
    {
        // Récupération et validation de l'ID
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id) || $id <= 0) {
            $error = "Identifiant d'espace invalide.";
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        // Récupération de l'espace existant
        $space = Space::findById($id);

        if (!$space) {
            $error = "L'espace demandé n'existe pas.";
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        // Vérification des réservations futures
        $hasReservations = Space::hasActiveReservations($id);

        // Traitement de la suppression si POST et pas de réservations
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($hasReservations) {
                // Bloquer la suppression
                $error = "Impossible de supprimer cet espace car il possède des réservations futures.";
            } else {
                // Supprimer l'espace
                $success = Space::delete($id);

                if ($success) {
                    // Démarrer la session si pas déjà fait
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    // Message flash de succès
                    $_SESSION['flash_success'] = "L'espace \"{$space['name']}\" a été supprimé avec succès.";

                    // Redirection vers la liste
                    header('Location: index.php?page=spaces');
                    exit;
                } else {
                    $error = "Une erreur est survenue lors de la suppression de l'espace.";
                }
            }
        }

        // Affichage de la page de confirmation
        require_once __DIR__ . '/../views/spaces/delete.php';
    }
}
