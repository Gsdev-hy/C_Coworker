<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="alert alert-danger text-center" role="alert">
                <h1 class="display-1">404</h1>
                <h4 class="alert-heading">Page non trouvée</h4>
                <p>
                    <?php echo htmlspecialchars($error ?? 'La ressource demandée n\'existe pas.'); ?>
                </p>
                <hr>
                <a href="index.php?page=spaces" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Retour à la liste des espaces
                </a>
            </div>
        </div>
    </div>
</div>