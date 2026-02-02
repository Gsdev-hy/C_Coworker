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
        global $pdo;  // Je sais, c'est pas clean, mais temporaire

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

    /**
     * Crée un nouvel espace dans la base de données
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param array $data Données de l'espace (name, capacity, type, equipment)
     * @return int|false ID de l'espace créé ou false en cas d'erreur
     */
    public static function create($data)
    {
        global $pdo;

        // Validation des données
        if (empty($data['name']) || empty($data['type']) || empty($data['capacity'])) {
            return false;
        }

        // Validation du type
        $validTypes = ['bureau', 'reunion', 'open-space'];
        if (!in_array($data['type'], $validTypes)) {
            return false;
        }

        // Validation de la capacité
        if (!is_numeric($data['capacity']) || $data['capacity'] <= 0) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("
                INSERT INTO spaces (name, capacity, type, equipment, created_at) 
                VALUES (:name, :capacity, :type, :equipment, NOW())
            ");

            $stmt->execute([
                ':name' => trim($data['name']),
                ':capacity' => (int) $data['capacity'],
                ':type' => $data['type'],
                ':equipment' => trim($data['equipment'] ?? '')
            ]);

            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log("Erreur lors de la création d'un espace : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère un espace par son ID
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $id ID de l'espace
     * @return array|null Données de l'espace ou null si non trouvé
     */
    public static function findById($id)
    {
        global $pdo;

        // Validation de l'ID
        if (!is_numeric($id) || $id <= 0) {
            return null;
        }

        try {
            $stmt = $pdo->prepare("
                SELECT id, name, capacity, type, equipment, created_at 
                FROM spaces 
                WHERE id = :id
            ");

            $stmt->execute([':id' => (int) $id]);
            $space = $stmt->fetch();

            return $space ?: null;

        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'espace #$id : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Met à jour un espace existant dans la base de données
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $id ID de l'espace à modifier
     * @param array $data Nouvelles données de l'espace
     * @return bool True si succès, false sinon
     */
    public static function update($id, $data)
    {
        global $pdo;

        // Validation de l'ID
        if (!is_numeric($id) || $id <= 0) {
            return false;
        }

        // Validation des données
        if (empty($data['name']) || empty($data['type']) || empty($data['capacity'])) {
            return false;
        }

        // Validation du type
        $validTypes = ['bureau', 'reunion', 'open-space'];
        if (!in_array($data['type'], $validTypes)) {
            return false;
        }

        // Validation de la capacité
        if (!is_numeric($data['capacity']) || $data['capacity'] <= 0) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("
                UPDATE spaces 
                SET name = :name, 
                    capacity = :capacity, 
                    type = :type, 
                    equipment = :equipment
                WHERE id = :id
            ");

            $result = $stmt->execute([
                ':id' => (int) $id,
                ':name' => trim($data['name']),
                ':capacity' => (int) $data['capacity'],
                ':type' => $data['type'],
                ':equipment' => trim($data['equipment'] ?? '')
            ]);

            return $result;

        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'espace #$id : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifie si un espace a des réservations futures (à partir d'aujourd'hui)
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $id ID de l'espace
     * @return bool True si des réservations futures existent, false sinon
     */
    public static function hasActiveReservations($id)
    {
        global $pdo;

        if (!is_numeric($id) || $id <= 0) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("
                SELECT COUNT(*) as count 
                FROM reservations 
                WHERE space_id = :id 
                AND end_time >= NOW()
            ");

            $stmt->execute([':id' => (int) $id]);
            $result = $stmt->fetch();

            return $result['count'] > 0;

        } catch (PDOException $e) {
            error_log("Erreur lors de la vérification des réservations pour l'espace #$id : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime un espace de la base de données
     * Note: Les réservations liées seront supprimées automatiquement (CASCADE)
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $id ID de l'espace à supprimer
     * @return bool True si succès, false sinon
     */
    public static function delete($id)
    {
        global $pdo;

        // Validation de l'ID
        if (!is_numeric($id) || $id <= 0) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM spaces WHERE id = :id");
            $result = $stmt->execute([':id' => (int) $id]);

            return $result;

        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'espace #$id : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Compte le nombre total d'espaces
     * 
     * @global PDO $pdo Connexion à la base de données
     * @return int Nombre d'espaces
     */
    public static function countAll()
    {
        global $pdo;

        try {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM spaces");
            $result = $stmt->fetch();
            return (int) $result['count'];
        } catch (PDOException $e) {
            return 0;
        }
    }
}
