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

                // Vérifier la disponibilité (MA2-16)
                if (empty($errors)) {
                    if (!Reservation::isAvailable($data['space_id'], $data['start_time'], $data['end_time'])) {
                        $errors[] = "Cet espace est déjà réservé sur ce créneau horaire. Veuillez choisir un autre moment ou un autre espace.";
                    }
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

    /**
     * Action : Afficher le formulaire de modification / Traiter la soumission
     * Route : ?page=reservations-edit&id=X
     */
    public function edit()
    {
        // Démarrer la session si pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Vous devez être connecté pour modifier une réservation.";
            header('Location: index.php?page=login');
            exit;
        }

        $user = $_SESSION['user'];

        // Récupération et validation de l'ID
        $id = $_GET['id'] ?? null;
        if (!$id || !is_numeric($id) || $id <= 0) {
            $_SESSION['flash_error'] = "Identifiant de réservation invalide.";
            header('Location: index.php?page=reservations');
            exit;
        }

        // Récupération de la réservation
        $reservation = Reservation::findById($id);
        if (!$reservation) {
            $_SESSION['flash_error'] = "La réservation demandée n'existe pas.";
            header('Location: index.php?page=reservations');
            exit;
        }

        // Vérifier les droits (admin ou propriétaire)
        if ($user['role'] !== 'admin' && $user['id'] != $reservation['user_id']) {
            $_SESSION['flash_error'] = "Vous n'avez pas l'autorisation de modifier cette réservation.";
            header('Location: index.php?page=reservations');
            exit;
        }

        // Récupérer tous les espaces pour le formulaire
        $spaces = Space::findAll();

        // Initialisation des erreurs
        $errors = [];

        // Traitement du formulaire si POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'space_id' => $_POST['space_id'] ?? '',
                'start_time' => ($_POST['start_date'] ?? '') . ' ' . ($_POST['start_time'] ?? ''),
                'end_time' => ($_POST['end_date'] ?? '') . ' ' . ($_POST['end_time'] ?? '')
            ];

            // Validation simple
            if (empty($data['space_id']))
                $errors[] = "L'espace est obligatoire.";
            if (empty($_POST['start_date']) || empty($_POST['start_time']))
                $errors[] = "Le début est obligatoire.";
            if (empty($_POST['end_date']) || empty($_POST['end_time']))
                $errors[] = "La fin est obligatoire.";

            if (empty($errors)) {
                $start = new DateTime($data['start_time']);
                $end = new DateTime($data['end_time']);

                if ($end <= $start) {
                    $errors[] = "La fin doit être après le début.";
                }

                // Vérifier la disponibilité (en excluant la réservation actuelle)
                if (empty($errors)) {
                    if (!Reservation::isAvailable($data['space_id'], $data['start_time'], $data['end_time'], $id)) {
                        $errors[] = "Ce créneau n'est pas disponible pour cet espace.";
                    }
                }
            }

            if (empty($errors)) {
                if (Reservation::update($id, $data)) {
                    $_SESSION['flash_success'] = "Réservation modifiée avec succès.";
                    header('Location: index.php?page=reservations');
                    exit;
                } else {
                    $errors[] = "Erreur lors de la mise à jour.";
                }
            }

            // Re-remplir la réservation avec les données POST pour la vue en cas d'erreur
            $reservation['space_id'] = $data['space_id'];
            $reservation['start_time'] = $data['start_time'];
            $reservation['end_time'] = $data['end_time'];
        }

        // Inclusion de la vue
        require_once __DIR__ . '/../views/reservations/edit.php';
    }
}
