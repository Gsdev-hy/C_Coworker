<?php
/**
 * Contrôleur Reservation
 * Gestion des actions liées aux réservations
 */

// Inclusion des modèles
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Space.php';

class ReservationController
{

    /**
     * Action : Liste de toutes les réservations
     * Route : ?page=reservations
     */
    public function index()
    {
        // Démarrer la session si pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Vous devez être connecté pour accéder à cette page.";
            header('Location: index.php?page=login');
            exit;
        }

        $user = $_SESSION['user'];

        // Si admin : toutes les réservations, sinon : seulement les siennes
        if ($user['role'] === 'admin') {
            $reservations = Reservation::findAll();
        } else {
            $reservations = Reservation::findByUserId($user['id']);
        }

        // Inclusion de la vue
        require_once __DIR__ . '/../views/reservations/index.php';
    }

    /**
     * Action : Afficher le formulaire de création / Traiter la soumission
     * Route : ?page=reservations-create
     */
    public function create()
    {
        // Démarrer la session si pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Vous devez être connecté pour créer une réservation.";
            header('Location: index.php?page=login');
            exit;
        }

        $user = $_SESSION['user'];

        // Récupérer tous les espaces pour le formulaire
        $spaces = Space::findAll();

        // Initialisation des variables pour la vue
        $errors = [];

        // Traitement du formulaire si POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données
            $data = [
                'user_id' => $user['id'],
                'space_id' => $_POST['space_id'] ?? '',
                'start_time' => $_POST['start_date'] . ' ' . $_POST['start_time'] ?? '',
                'end_time' => $_POST['end_date'] . ' ' . $_POST['end_time'] ?? ''
            ];

            // Validation côté serveur
            if (empty($data['space_id'])) {
                $errors[] = "Vous devez sélectionner un espace.";
            }

            if (empty($_POST['start_date']) || empty($_POST['start_time'])) {
                $errors[] = "La date et l'heure de début sont obligatoires.";
            }

            if (empty($_POST['end_date']) || empty($_POST['end_time'])) {
                $errors[] = "La date et l'heure de fin sont obligatoires.";
            }

            // Validation que la fin est après le début
            if (empty($errors)) {
                $start = new DateTime($data['start_time']);
                $end = new DateTime($data['end_time']);

                if ($end <= $start) {
                    $errors[] = "L'heure de fin doit être après l'heure de début.";
                }

                // Vérifier que la réservation est dans le futur
                $now = new DateTime();
                if ($start < $now) {
                    $errors[] = "Vous ne pouvez pas créer une réservation dans le passé.";
                }
            }

            // Si pas d'erreurs, créer la réservation
            if (empty($errors)) {
                $reservationId = Reservation::create($data);

                if ($reservationId) {
                    $_SESSION['flash_success'] = "Votre réservation a été créée avec succès.";
                    header('Location: index.php?page=reservations');
                    exit;
                } else {
                    $errors[] = "Une erreur est survenue lors de la création de la réservation.";
                }
            }
        }

        // Affichage du formulaire
        require_once __DIR__ . '/../views/reservations/create.php';
    }
}
