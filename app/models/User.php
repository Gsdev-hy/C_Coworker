<?php
/**
 * Modèle User
 * Gestion des utilisateurs (administrateurs et utilisateurs standards)
 */

class User
{

    /**
     * Récupère un utilisateur par son email
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param string $email Email de l'utilisateur
     * @return array|null Données de l'utilisateur ou null si non trouvé
     */
    public static function findByEmail($email)
    {
        global $pdo;

        // Validation de l'email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        try {
            $stmt = $pdo->prepare("
                SELECT id, firstname, lastname, email, password, role, created_at 
                FROM users 
                WHERE email = :email
            ");

            $stmt->execute([':email' => trim($email)]);
            $user = $stmt->fetch();

            return $user ?: null;

        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Vérifie si un utilisateur est administrateur
     * 
     * @param array $user Données de l'utilisateur
     * @return bool True si admin, false sinon
     */
    public static function isAdmin($user)
    {
        return isset($user['role']) && $user['role'] === 'admin';
    }
}
