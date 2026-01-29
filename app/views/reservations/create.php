<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-calendar-plus"></i> 
                        Nouvelle réservation
                    </h3>
                </div>
                <div class="card-body">
                    
                    <?php if (!empty($errors)): ?>
                        <!-- Affichage des erreurs -->
                        <div class="alert alert-danger" role="alert">
                            <strong>Erreur(s) détectée(s) :</strong>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire de création -->
                    <form method="POST" action="index.php?page=reservations-create">
                        
                        <!-- Sélection de l'espace -->
                        <div class="mb-3">
                            <label for="space_id" class="form-label">
                                Espace <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="space_id" name="space_id" required>
                                <option value="">-- Sélectionnez un espace --</option>
                                <?php foreach ($spaces as $space): ?>
                                    <option value="<?php echo $space['id']; ?>"
                                            <?php echo (($_POST['space_id'] ?? '') == $space['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($space['name']); ?> 
                                        (<?php echo ucfirst($space['type']); ?> - 
                                        <?php echo $space['capacity']; ?> pers.)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <!-- Date de début -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">
                                        Date de début <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="<?php echo htmlspecialchars($_POST['start_date'] ?? date('Y-m-d')); ?>"
                                           min="<?php echo date('Y-m-d'); ?>"
                                           required>
                                </div>
                            </div>

                            <!-- Heure de début -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">
                                        Heure de début <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" 
                                           class="form-control" 
                                           id="start_time" 
                                           name="start_time" 
                                           value="<?php echo htmlspecialchars($_POST['start_time'] ?? '09:00'); ?>"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Date de fin -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">
                                        Date de fin <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="<?php echo htmlspecialchars($_POST['end_date'] ?? date('Y-m-d')); ?>"
                                           min="<?php echo date('Y-m-d'); ?>"
                                           required>
                                </div>
                            </div>

                            <!-- Heure de fin -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">
                                        Heure de fin <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" 
                                           class="form-control" 
                                           id="end_time" 
                                           name="end_time" 
                                           value="<?php echo htmlspecialchars($_POST['end_time'] ?? '10:00'); ?>"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Note d'information -->
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Note :</strong> La vérification des conflits de réservation sera effectuée lors de la validation.
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between">
                            <a href="index.php?page=reservations" class="btn btn-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Créer la réservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
