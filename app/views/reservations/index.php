<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-calendar-check"></i>
            <?php echo ($user['role'] === 'admin') ? 'Toutes les réservations' : 'Mes réservations'; ?>
        </h2>
        <a href="index.php?page=reservations-create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvelle réservation
        </a>
    </div>

    <?php if (empty($reservations)): ?>
        <!-- Message si aucune réservation -->
        <div class="alert alert-info" role="alert">
            <strong>Aucune réservation.</strong>
            Créez votre première réservation pour commencer.
        </div>
    <?php else: ?>
        <!-- Tableau des réservations -->
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <?php if ($user['role'] === 'admin'): ?>
                            <th>Utilisateur</th>
                        <?php endif; ?>
                        <th>Espace</th>
                        <th>Type</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Durée</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <?php
                        $start = new DateTime($reservation['start_time']);
                        $end = new DateTime($reservation['end_time']);
                        $now = new DateTime();
                        $interval = $start->diff($end);

                        // Déterminer le statut
                        if ($end < $now) {
                            $status = 'Terminée';
                            $statusClass = 'bg-secondary';
                        } elseif ($start <= $now && $end >= $now) {
                            $status = 'En cours';
                            $statusClass = 'bg-success';
                        } else {
                            $status = 'À venir';
                            $statusClass = 'bg-primary';
                        }
                        ?>
                        <tr>
                            <?php if ($user['role'] === 'admin'): ?>
                                <td>
                                    <i class="bi bi-person"></i>
                                    <?php echo htmlspecialchars($reservation['user_firstname'] . ' ' . $reservation['user_lastname']); ?>
                                </td>
                            <?php endif; ?>
                            <td><strong>
                                    <?php echo htmlspecialchars($reservation['space_name']); ?>
                                </strong></td>
                            <td>
                                <?php
                                $badgeClass = match ($reservation['space_type']) {
                                    'bureau' => 'bg-primary',
                                    'reunion' => 'bg-success',
                                    'open-space' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo ucfirst(htmlspecialchars($reservation['space_type'])); ?>
                                </span>
                            </td>
                            <td>
                                <?php echo $start->format('d/m/Y H:i'); ?>
                            </td>
                            <td>
                                <?php echo $end->format('d/m/Y H:i'); ?>
                            </td>
                            <td>
                                <?php
                                if ($interval->h > 0) {
                                    echo $interval->h . 'h';
                                    if ($interval->i > 0)
                                        echo ' ' . $interval->i . 'min';
                                } else {
                                    echo $interval->i . 'min';
                                }
                                ?>
                            </td>
                            <td>
                                <span class="badge <?php echo $statusClass; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($status === 'À venir'): ?>
                                    <a href="index.php?page=reservations-edit&id=<?php echo $reservation['id']; ?>"
                                        class="btn btn-sm btn-warning" title="Modifier">
                                        Modifier
                                    </a>
                                    <a href="index.php?page=reservations-delete&id=<?php echo $reservation['id']; ?>"
                                        class="btn btn-sm btn-danger" title="Annuler"
                                        onclick="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                                        Annuler
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>