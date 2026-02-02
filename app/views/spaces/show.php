<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <!-- Bouton retour -->
            <div class="mb-3">
                <a href="index.php?page=spaces" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Carte principale -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="bi bi-building"></i>
                        <?php echo htmlspecialchars($space['name']); ?>
                    </h3>
                    <span class="badge bg-light text-dark fs-6">
                        ID:
                        <?php echo $space['id']; ?>
                    </span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Colonne gauche : Informations principales -->
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Informations générales</h5>

                            <div class="mb-3">
                                <label class="fw-bold text-muted">Type d'espace :</label>
                                <div class="mt-1">
                                    <?php
                                    $badgeClass = match ($space['type']) {
                                        'bureau' => 'bg-primary',
                                        'reunion' => 'bg-success',
                                        'open-space' => 'bg-info',
                                        default => 'bg-secondary'
                                    };
                                    $typeLabel = match ($space['type']) {
                                        'bureau' => 'Bureau',
                                        'reunion' => 'Salle de réunion',
                                        'open-space' => 'Open-space',
                                        default => ucfirst($space['type'])
                                    };
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?> fs-6">
                                        <?php echo $typeLabel; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-muted">Capacité :</label>
                                <div class="mt-1">
                                    <span class="fs-5">
                                        <i class="bi bi-people-fill text-primary"></i>
                                        <?php echo htmlspecialchars($space['capacity']); ?> personne(s)
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-muted">Date de création :</label>
                                <div class="mt-1">
                                    <i class="bi bi-calendar-check"></i>
                                    <?php
                                    $date = new DateTime($space['created_at']);
                                    echo $date->format('d/m/Y à H:i');
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Colonne droite : Équipements -->
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Équipements disponibles</h5>

                            <?php if (!empty($space['equipment'])): ?>
                                <ul class="list-group">
                                    <?php
                                    // Séparer les équipements par virgule
                                    $equipments = array_map('trim', explode(',', $space['equipment']));
                                    foreach ($equipments as $equipment):
                                        ?>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                            <?php echo htmlspecialchars($equipment); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <div class="alert alert-info" role="alert">
                                    <i class="bi bi-info-circle"></i>
                                    Aucun équipement spécifié pour cet espace.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Footer avec actions -->
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <a href="index.php?page=spaces-edit&id=<?php echo $space['id']; ?>" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Modifier cet espace
                        </a>
                        <a href="index.php?page=spaces-delete&id=<?php echo $space['id']; ?>" class="btn btn-danger"
                            onclick="return confirm('Voulez-vous vraiment supprimer cet espace ? Cette action est irréversible.');">
                            <i class="bi bi-trash"></i> Supprimer
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>