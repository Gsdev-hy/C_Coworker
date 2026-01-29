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
}
