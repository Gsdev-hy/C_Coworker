<?php
/**
 * Helper d'authentification
 * Fournit des méthodes pour sécuriser les accès
 */

class AuthHelper
{
    /**
     * Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
     * 
     * @return void
     */
    public static function requireLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Vous devez être connecté pour accéder à cette fonctionnalité.";
            header('Location: index.php?page=login');
            exit;
        }
    }

    /**
     * Vérifie si l'utilisateur est administrateur, sinon redirige ou affiche une erreur
     * 
     * @return void
     */
    public static function requireAdmin()
    {
        self::requireLogin();

        if ($_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash_error'] = "Accès refusé. Cette action est réservée aux administrateurs.";
            header('Location: index.php?page=spaces');
            exit;
        }
    }

    /**
     * Vérifie si l'utilisateur est connecté
     * 
     * @return bool
     */
    public static function isLoggedIn()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']);
    }

    /**
     * Vérifie si l'utilisateur connecté est admin
     * 
     * @return bool
     */
    public static function isAdmin()
    {
        return self::isLoggedIn() && $_SESSION['user']['role'] === 'admin';
    }
}
