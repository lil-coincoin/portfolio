
<?php $title = "Contact"; ?>
<?php ob_start(); ?>
        <div class="text-center pt-5">
            <h1>Nous contacter</h1>
        </div>
        <!-- Message d'erreur -->
        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Message de succès -->
        <?php if(isset($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="8"></textarea>
            </div>
            <button class="btn btn-primary">
                Envoyer le message
            </button>
        </form>
<?php $content = ob_get_clean(); ?>