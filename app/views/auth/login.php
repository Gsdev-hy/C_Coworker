<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">
                        <i class="bi bi-lock"></i>
                        Connexion
                    </h3>
                </div>
                <div class="card-body p-4">

                    <!-- Logo ou titre de l'application -->
                    <div class="text-center mb-4">
                        <h4 class="text-primary">C'Coworker</h4>
                        <p class="text-muted">Gestion d'espaces de coworking</p>
                    </div>

                    <?php if (!empty($errors)): ?>
                        <!-- Affichage des erreurs -->
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li>
                                        <?php echo htmlspecialchars($error); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire de connexion -->
                    <form method="POST" action="index.php?page=login">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required autofocus
                                placeholder="votre.email@example.com">
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-key"></i> Mot de passe
                            </label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                required placeholder="••••••••">
                        </div>

                        <!-- Bouton de connexion -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Se connecter
                            </button>
                        </div>
                    </form>

                    <!-- Informations de test -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            <strong>Compte de test :</strong><br>
                            Email : <code>admin@coworker.com</code><br>
                            Mot de passe : <code>admin123</code>
                        </small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>