<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-exclamation-triangle"></i>
                        Supprimer un espace
                    </h3>
                </div>
                <div class="card-body">

                    <?php if (isset($error)): ?>
                        <!-- Affichage de l'erreur -->
                        <div class="alert alert-danger" role="alert">
                            <strong>Erreur !</strong>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="index.php?page=spaces-show&id=<?php echo $space['id']; ?>" class="btn btn-secondary">
                                Retour à l'espace
                            </a>
                        </div>
                    <?php else: ?>

                        <!-- Informations de l'espace à supprimer -->
                        <div class="alert alert-warning" role="alert">
                            <h5 class="alert-heading">
                                <i class="bi bi-info-circle"></i>
                                Vous êtes sur le point de supprimer l'espace suivant :
                            </h5>
                            <hr>
                            <p class="mb-1"><strong>Nom :</strong>
                                <?php echo htmlspecialchars($space['name']); ?>
                            </p>
                            <p class="mb-1"><strong>Type :</strong>
                                <?php echo ucfirst(htmlspecialchars($space['type'])); ?>
                            </p>
                            <p class="mb-0"><strong>Capacité :</strong>
                                <?php echo htmlspecialchars($space['capacity']); ?> personne(s)
                            </p>
                        </div>

                        <?php if ($hasReservations): ?>
                            <!-- Blocage : Réservations futures détectées -->
                            <div class="alert alert-danger" role="alert">
                                <h5 class="alert-heading">
                                    <i class="bi bi-x-circle"></i>
                                    Suppression impossible
                                </h5>
                                <p class="mb-0">
                                    Cet espace possède des <strong>réservations futures</strong>.
                                    Vous devez d'abord annuler toutes les réservations avant de pouvoir supprimer cet espace.
                                </p>
                            </div>

                            <div class="text-center mt-4">
                                <a href="index.php?page=spaces-show&id=<?php echo $space['id']; ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Retour à l'espace
                                </a>
                                <a href="index.php?page=reservations" class="btn btn-primary">
                                    <i class="bi bi-calendar-check"></i> Voir les réservations
                                </a>
                            </div>

                        <?php else: ?>
                            <!-- Confirmation de suppression -->
                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-check-circle"></i>
                                Aucune réservation future détectée. La suppression est possible.
                            </div>

                            <div class="alert alert-danger" role="alert">
                                <strong>Attention :</strong> Cette action est <strong>irréversible</strong>.
                                Toutes les données liées à cet espace seront définitivement supprimées.
                            </div>

                            <!-- Formulaire de confirmation -->
                            <form method="POST" action="index.php?page=spaces-delete&id=<?php echo $space['id']; ?>">
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="index.php?page=spaces-show&id=<?php echo $space['id']; ?>"
                                        class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Êtes-vous absolument certain de vouloir supprimer cet espace ?');">
                                        <i class="bi bi-trash"></i> Confirmer la suppression
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>