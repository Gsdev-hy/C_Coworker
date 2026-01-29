<?php
/**
 * Modèle Space
 * Gestion des espaces de coworking (bureaux, salles de réunion, open-spaces)
 */

class Space
{

    /**
     * Récupère tous les espaces depuis la base de données
     * 
     * @global PDO $pdo Connexion à la base de données
     * @return array Tableau associatif des espaces
     */
    public static function findAll()
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("
                SELECT id, name, capacity, type, equipment, created_at 
                FROM spaces 
                ORDER BY name ASC
            ");

            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            // En production, logger l'erreur au lieu de l'afficher
            error_log("Erreur lors de la récupération des espaces : " . $e->getMessage());
            return [];
        }
    }
}
