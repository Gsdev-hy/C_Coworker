<?php
/**
 * Contrôleur Planning
 * Gestion de l'affichage hebdomadaire des réservations
 */

require_once 'models/Reservation.php';

class PlanningController
{
    /**
     * Action : Afficher le planning hebdomadaire
     * Route : ?page=planning
     */
    public function index()
    {
        AuthHelper::requireLogin();

        // Récupération de la date de référence (aujourd'hui par défaut)
        $dateRef = $_GET['week'] ?? date('Y-m-d');
        $dt = new DateTime($dateRef);

        // Trouver le lundi de cette semaine
        $dt->modify('monday this week');
        $startOfWeek = $dt->format('Y-m-d');

        // Trouver le dimanche de cette semaine
        $dt->modify('sunday this week');
        $endOfWeek = $dt->format('Y-m-d');

        // Calcul des semaines précédente et suivante pour la navigation
        $prevWeek = (new DateTime($startOfWeek))->modify('-1 week')->format('Y-m-d');
        $nextWeek = (new DateTime($startOfWeek))->modify('+1 week')->format('Y-m-d');

        // Récupération des réservations pour cette période
        $reservations = Reservation::findByDateRange($startOfWeek, $endOfWeek);

        // Organisation des réservations par jour pour faciliter l'affichage
        $planning = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            $planning[$day] = [];
        }

        foreach ($reservations as $res) {
            $dayName = (new DateTime($res['start_time']))->format('l');
            $planning[$dayName][] = $res;
        }

        // Traduction des jours pour la vue
        $dayLabels = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];

        // Inclusion de la vue
        require_once __DIR__ . '/../views/planning/index.php';
    }
}
