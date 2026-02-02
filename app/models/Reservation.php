<?php
/**
 * Modèle Reservation
 * Gestion des réservations d'espaces
 */

class Reservation
{

    /**
     * Récupère toutes les réservations avec informations utilisateur et espace
     * 
     * @global PDO $pdo Connexion à la base de données
     * @return array Tableau associatif des réservations
     */
    public static function findAll()
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("
                SELECT 
                    r.id,
                    r.start_time,
                    r.end_time,
                    r.created_at,
                    u.id as user_id,
                    u.firstname as user_firstname,
                    u.lastname as user_lastname,
                    s.id as space_id,
                    s.name as space_name,
                    s.type as space_type
                FROM reservations r
                INNER JOIN users u ON r.user_id = u.id
                INNER JOIN spaces s ON r.space_id = s.id
                ORDER BY r.start_time DESC
            ");

            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des réservations : " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les réservations pour une période donnée
     * 
     * @param string $start Date de début (Y-m-d)
     * @param string $end Date de fin (Y-m-d)
     * @return array
     */
    public static function findByDateRange($start, $end)
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("
                SELECT 
                    r.*, 
                    s.name as space_name, s.type as space_type,
                    u.firstname as user_firstname, u.lastname as user_lastname
                FROM reservations r
                INNER JOIN spaces s ON r.space_id = s.id
                INNER JOIN users u ON r.user_id = u.id
                WHERE r.start_time <= :end AND r.end_time >= :start
                ORDER BY r.start_time ASC
            ");

            $stmt->execute([
                ':start' => $start . ' 00:00:00',
                ':end' => $end . ' 23:59:59'
            ]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Récupère les réservations d'un utilisateur spécifique
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $userId ID de l'utilisateur
     * @return array Tableau associatif des réservations
     */
    public static function findByUserId($userId)
    {
        global $pdo;

        if (!is_numeric($userId) || $userId <= 0) {
            return [];
        }

        try {
            $stmt = $pdo->prepare("
                SELECT 
                    r.id,
                    r.start_time,
                    r.end_time,
                    r.created_at,
                    s.id as space_id,
                    s.name as space_name,
                    s.type as space_type,
                    s.capacity as space_capacity
                FROM reservations r
                INNER JOIN spaces s ON r.space_id = s.id
                WHERE r.user_id = :user_id
                ORDER BY r.start_time DESC
            ");

            $stmt->execute([':user_id' => (int) $userId]);
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des réservations de l'utilisateur #$userId : " . $e->getMessage());
            return [];
        }
    }

    /**
     * Crée une nouvelle réservation
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param array $data Données de la réservation (user_id, space_id, start_time, end_time)
     * @return int|false ID de la réservation créée ou false en cas d'erreur
     */
    public static function create($data)
    {
        global $pdo;

        // Validation des données
        if (
            empty($data['user_id']) || empty($data['space_id']) ||
            empty($data['start_time']) || empty($data['end_time'])
        ) {
            return false;
        }

        // Validation que l'heure de fin est après l'heure de début
        $start = new DateTime($data['start_time']);
        $end = new DateTime($data['end_time']);

        if ($end <= $start) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("
                INSERT INTO reservations (user_id, space_id, start_time, end_time, created_at) 
                VALUES (:user_id, :space_id, :start_time, :end_time, NOW())
            ");

            $stmt->execute([
                ':user_id' => (int) $data['user_id'],
                ':space_id' => (int) $data['space_id'],
                ':start_time' => $data['start_time'],
                ':end_time' => $data['end_time']
            ]);

            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log("Erreur lors de la création de la réservation : " . $e->getMessage());
            return false;
        }
    }
    /**
     * Vérifie si un créneau est disponible pour un espace donné
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $spaceId ID de l'espace
     * @param string $startTime Date et heure de début (Y-m-d H:i:s)
     * @param string $endTime Date et heure de fin (Y-m-d H:i:s)
     * @param int|null $excludeId ID de réservation à exclure (utile pour la modification)
     * @return bool True si disponible, false si conflit
     */
    public static function isAvailable($spaceId, $startTime, $endTime, $excludeId = null)
    {
        global $pdo;

        try {
            $sql = "
                SELECT COUNT(*) as count 
                FROM reservations 
                WHERE space_id = :space_id 
                AND (:start_time < end_time AND :end_time > start_time)
            ";

            if ($excludeId) {
                $sql .= " AND id != :exclude_id";
            }

            $stmt = $pdo->prepare($sql);
            $params = [
                ':space_id' => (int) $spaceId,
                ':start_time' => $startTime,
                ':end_time' => $endTime
            ];

            if ($excludeId) {
                $params[':exclude_id'] = (int) $excludeId;
            }

            $stmt->execute($params);
            $result = $stmt->fetch();

            return $result['count'] == 0;

        } catch (PDOException $e) {
            error_log("Erreur lors de la vérification de disponibilité : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère une réservation par son ID
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $id ID de la réservation
     * @return array|null Données de la réservation ou null si non trouvée
     */
    public static function findById($id)
    {
        global $pdo;

        if (!is_numeric($id) || $id <= 0) {
            return null;
        }

        try {
            $stmt = $pdo->prepare("
                SELECT * FROM reservations WHERE id = :id
            ");

            $stmt->execute([':id' => (int) $id]);
            $reservation = $stmt->fetch();

            return $reservation ?: null;

        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la réservation #$id : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Met à jour une réservation existante
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $id ID de la réservation
     * @param array $data Nouvelles données
     * @return bool True si succès, false sinon
     */
    public static function update($id, $data)
    {
        global $pdo;

        if (!is_numeric($id) || $id <= 0) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("
                UPDATE reservations 
                SET space_id = :space_id, 
                    start_time = :start_time, 
                    end_time = :end_time
                WHERE id = :id
            ");

            return $stmt->execute([
                ':id' => (int) $id,
                ':space_id' => (int) $data['space_id'],
                ':start_time' => $data['start_time'],
                ':end_time' => $data['end_time']
            ]);

        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de la réservation #$id : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime une réservation
     * 
     * @global PDO $pdo Connexion à la base de données
     * @param int $id ID de la réservation
     * @return bool True si succès, false sinon
     */
    public static function delete($id)
    {
        global $pdo;

        if (!is_numeric($id) || $id <= 0) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = :id");
            return $stmt->execute([':id' => (int) $id]);

        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de la réservation #$id : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Compte le nombre de réservations actives (futures ou en cours)
     * 
     * @global PDO $pdo Connexion à la base de données
     * @return int Nombre de réservations actives
     */
    public static function countActive()
    {
        global $pdo;

        try {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM reservations WHERE end_time >= NOW()");
            $result = $stmt->fetch();
            return (int) $result['count'];
        } catch (PDOException $e) {
            return 0;
        }
    }
}
