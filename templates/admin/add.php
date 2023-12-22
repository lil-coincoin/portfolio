<?php $title = "login"; ?>
<?php ob_start(); ?>
<a href="/admin">Retour</a>
    <h2 class="my-4">Ajout d'un projet</h2>

    <!-- Message de succès -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Messages d'erreurs -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>

        <div class="mb-3">
            <label for="desc" class="form-label">Description</label>
            <textarea class="form-control" id="desc" name="desc" rows="6"></textarea>
        </div>

        <div class="mb-3">
            <label for="preview" class="form-label">Couverture</label>
            <input type="file" class="form-control" id="preview" name="preview">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
<?php $content = ob_get_clean(); ?>