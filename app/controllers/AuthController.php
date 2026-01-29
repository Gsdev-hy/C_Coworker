<?php
/**
 * Contrôleur Auth
 * Gestion de l'authentification (login, logout)
 */

// Inclusion du modèle
require_once __DIR__ . '/../models/User.php';

class AuthController
{

    /**
     * Action : Afficher le formulaire de connexion / Traiter la connexion
     * Route : ?page=login
     */
    public function login()
    {
        // Démarrer la session si pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si déjà connecté, rediriger vers le dashboard
        if (isset($_SESSION['user'])) {
            header('Location: index.php?page=spaces');
            exit;
        }

        // Initialisation des variables pour la vue
        $errors = [];

        // Traitement du formulaire si POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validation côté serveur
            if (empty($email)) {
                $errors[] = "L'email est obligatoire.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas valide.";
            }

            if (empty($password)) {
                $errors[] = "Le mot de passe est obligatoire.";
            }

            // Si pas d'erreurs, vérifier les identifiants
            if (empty($errors)) {
                $user = User::findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    // Connexion réussie
                    // Stocker les informations utilisateur en session (sans le mot de passe)
                    unset($user['password']);
                    $_SESSION['user'] = $user;

                    // Message flash de succès
                    $_SESSION['flash_success'] = "Bienvenue, {$user['firstname']} {$user['lastname']} !";

                    // Redirection vers la liste des espaces
                    header('Location: index.php?page=spaces');
                    exit;
                } else {
                    // Identifiants incorrects
                    $errors[] = "Email ou mot de passe incorrect.";
                }
            }
        }

        // Affichage du formulaire de connexion
        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Action : Déconnexion
     * Route : ?page=logout
     */
    public function logout()
    {
        // Démarrer la session si pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Détruire toutes les données de session
        $_SESSION = [];

        // Détruire le cookie de session
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // Détruire la session
        session_destroy();

        // Redirection vers la page de connexion
        header('Location: index.php?page=login');
        exit;
    }
}
