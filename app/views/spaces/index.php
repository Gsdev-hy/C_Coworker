<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des espaces</h2>
        <a href="index.php?page=spaces-create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Ajouter un espace
        </a>
    </div>

    <?php if (empty($spaces)): ?>
        <!-- Message si aucun espace -->
        <div class="alert alert-info" role="alert">
            <strong>Aucun espace disponible.</strong>
            Commencez par ajouter un espace pour gérer vos réservations.
        </div>
    <?php else: ?>
        <!-- Tableau des espaces -->
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Capacité</th>
                        <th>Équipements</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($spaces as $space): ?>
                        <tr>
                            <td><strong>
                                    <?php echo htmlspecialchars($space['name']); ?>
                                </strong></td>
                            <td>
                                <?php
                                // Badge coloré selon le type
                                $badgeClass = match ($space['type']) {
                                    'bureau' => 'bg-primary',
                                    'reunion' => 'bg-success',
                                    'open-space' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo ucfirst(htmlspecialchars($space['type'])); ?>
                                </span>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($space['capacity']); ?> pers.
                            </td>
                            <td>
                                <?php
                                // Affichage des équipements (ou "Aucun")
                                echo !empty($space['equipment'])
                                    ? htmlspecialchars($space['equipment'])
                                    : '<em class="text-muted">Aucun</em>';
                                ?>
                            </td>
                            <td>
                                <a href="index.php?page=spaces-show&id=<?php echo $space['id']; ?>" class="btn btn-sm btn-info"
                                    title="Voir les détails">
                                    Détails
                                </a>
                                <a href="index.php?page=spaces-edit&id=<?php echo $space['id']; ?>"
                                    class="btn btn-sm btn-warning" title="Modifier">
                                    Modifier
                                </a>
                                <a href="index.php?page=spaces-delete&id=<?php echo $space['id']; ?>"
                                    class="btn btn-sm btn-danger" title="Supprimer"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cet espace ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>