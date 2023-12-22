<?php $title = "Accueil"; ?>
<?php ob_start(); ?>
        <div class="text-center pt-5">
            <h1>Nos merveilleux projets</h1>
        </div>
        <div class="articles p-5">
            <?php foreach($projets as $projet): ?>
                <article class="pb-5">
                    <!-- Titre de l'article -->
                    <h1><?php echo $projet->getTitle(); ?></h1>

                    <!-- Informations sur l'article -->
                    <small class="d-block text-secondary pb-2">
                        Posté <?php echo $projet->getCreatedAt()->format('d.m.Y');?>
                    </small>

                    <!-- Image de couverture -->
                    <img
                        src="<?php echo "{$projet->getFolderPreview()}" ?>"
                        alt="<?php echo $projet->getTitle(); ?>"
                        class="img-fluid rounded"
                    >

                    <!-- Contenu tronqué de l'article -->
                    <p><?php echo mb_strimwidth($projet->getDescription(), 0, 75, '...'); ?></p>

                    <a href="projet?id=<?php echo $projet->getId(); ?>" class="btn btn-sm btn-primary">
                        Lire la suite...
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
<?php $content = ob_get_clean(); ?>