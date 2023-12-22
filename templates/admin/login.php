<?php $title = "login"; ?>
<?php ob_start(); ?>
    <form method="post">
        <h2 class="mb-4">
            Connexion à l'administration
        </h2>

        <!-- Mes erreurs ici -->
        <?php
            if (isset($_SESSION['error'])):
        ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; ?>
            </div>
        <?php
            // Destruction de la session "error"
            unset($_SESSION['error']);
            endif
        ?>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="d-grid gap-2 d-md-block">
            <button class="btn btn-primary">
                Se connecter
            </button>
        </div>
    </form>
<?php $content = ob_get_clean(); ?>