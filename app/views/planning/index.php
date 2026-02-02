<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-calendar3"></i> Planning Hebdomadaire</h2>
        <div class="btn-group shadow-sm">
            <a href="index.php?page=planning&week=<?php echo $prevWeek; ?>" class="btn btn-outline-primary">
                <i class="bi bi-chevron-left"></i> Semaine précédente
            </a>
            <a href="index.php?page=planning&week=<?php echo date('Y-m-d'); ?>" class="btn btn-primary">
                Aujourd'hui
            </a>
            <a href="index.php?page=planning&week=<?php echo $nextWeek; ?>" class="btn btn-outline-primary">
                Semaine suivante <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>

    <div class="alert alert-info text-center py-2 shadow-sm">
        <strong>Période :</strong> Du
        <?php echo (new DateTime($startOfWeek))->format('d/m/Y'); ?>
        au
        <?php echo (new DateTime($endOfWeek))->format('d/m/Y'); ?>
    </div>

    <div class="row row-cols-1 row-cols-md-7 g-2 planning-grid">
        <?php foreach ($dayLabels as $eng => $fr): ?>
            <?php
            $currentDayDate = (new DateTime($startOfWeek))->modify('+' . array_search($eng, array_keys($dayLabels)) . ' days');
            $isToday = $currentDayDate->format('Y-m-d') === date('Y-m-d');
            ?>
            <div class="col">
                <div class="card h-100 <?php echo $isToday ? 'border-primary shadow' : ''; ?>">
                    <div class="card-header <?php echo $isToday ? 'bg-primary text-white' : 'bg-light'; ?> text-center p-2">
                        <div class="fw-bold">
                            <?php echo $fr; ?>
                        </div>
                        <small>
                            <?php echo $currentDayDate->format('d/m'); ?>
                        </small>
                    </div>
                    <div class="card-body p-2" style="min-height: 300px; background-color: #f8f9fa;">
                        <?php if (empty($planning[$eng])): ?>
                            <div class="text-center text-muted mt-4">
                                <small>Libre</small>
                            </div>
                        <?php else: ?>
                            <?php foreach ($planning[$eng] as $res): ?>
                                <?php
                                $startTime = (new DateTime($res['start_time']))->format('H:i');
                                $endTime = (new DateTime($res['end_time']))->format('H:i');
                                $typeColor = match ($res['space_type']) {
                                    'bureau' => 'border-primary',
                                    'reunion' => 'border-success',
                                    'open-space' => 'border-info',
                                    default => 'border-secondary'
                                };
                                ?>
                                <div class="card mb-2 border-start border-4 <?php echo $typeColor; ?> shadow-sm">
                                    <div class="p-2" style="font-size: 0.85rem;">
                                        <div class="fw-bold text-truncate"
                                            title="<?php echo htmlspecialchars($res['space_name']); ?>">
                                            <?php echo htmlspecialchars($res['space_name']); ?>
                                        </div>
                                        <div class="text-muted">
                                            <i class="bi bi-clock"></i>
                                            <?php echo $startTime; ?> -
                                            <?php echo $endTime; ?>
                                        </div>
                                        <div class="text-primary mt-1">
                                            <i class="bi bi-person small"></i>
                                            <?php echo htmlspecialchars($res['user_firstname']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Style spécifique pour la grille 7 colonnes en desktop */
    @media (min-width: 768px) {
        .row-cols-md-7>* {
            flex: 0 0 auto;
            width: 14.2857%;
        }
    }

    .planning-grid .card {
        transition: transform 0.2s;
    }

    .planning-grid .card:hover {
        transform: scale(1.02);
    }
</style>