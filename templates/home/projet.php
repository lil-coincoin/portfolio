<?php $title = "Detail projet"; ?>
<?php ob_start(); ?>
<div class="text-center pt-5">
        <h1>detail projet </h1>
        </div>

        <div class="articles p-5">
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
                <p><?php echo $projet->getDescription(); ?></p>

                <a href="/" class="btn btn-sm btn-primary">Retour à la liste de projets</a>
            </article>

        </div>
<?php $content = ob_get_clean(); ?>