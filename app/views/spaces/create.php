<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Ajouter un espace</h3>
                </div>
                <div class="card-body">

                    <?php if (!empty($errors)): ?>
                        <!-- Affichage des erreurs -->
                        <div class="alert alert-danger" role="alert">
                            <strong>Erreur(s) détectée(s) :</strong>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li>
                                        <?php echo htmlspecialchars($error); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire de création -->
                    <form method="POST" action="index.php?page=spaces-create">

                        <!-- Nom de l'espace -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de l'espace <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required maxlength="100"
                                placeholder="Ex: Salle A, Bureau 1, Open Space Principal">
                        </div>

                        <!-- Type d'espace -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Type d'espace <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">-- Sélectionnez un type --</option>
                                <option value="bureau" <?php echo (($_POST['type'] ?? '') === 'bureau') ? 'selected' : ''; ?>>
                                    Bureau
                                </option>
                                <option value="reunion" <?php echo (($_POST['type'] ?? '') === 'reunion') ? 'selected' : ''; ?>>
                                    Salle de réunion
                                </option>
                                <option value="open-space" <?php echo (($_POST['type'] ?? '') === 'open-space') ? 'selected' : ''; ?>>
                                    Open-space
                                </option>
                            </select>
                        </div>

                        <!-- Capacité -->
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacité (nombre de personnes) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="capacity" name="capacity"
                                value="<?php echo htmlspecialchars($_POST['capacity'] ?? ''); ?>" required min="1"
                                max="100" placeholder="Ex: 10">
                        </div>

                        <!-- Équipements -->
                        <div class="mb-3">
                            <label for="equipment" class="form-label">Équipements disponibles</label>
                            <textarea class="form-control" id="equipment" name="equipment" rows="3"
                                placeholder="Ex: Wifi, Projecteur, Tableau blanc, Machine à café"><?php echo htmlspecialchars($_POST['equipment'] ?? ''); ?></textarea>
                            <small class="form-text text-muted">Séparez les équipements par des virgules.</small>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between">
                            <a href="index.php?page=spaces" class="btn btn-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Enregistrer l'espace
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>