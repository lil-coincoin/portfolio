<?php $title = "dashboard"; ?>
<?php ob_start(); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-4">Liste des projets</h2>
        <a href="/add" class="btn btn-success">Nouvel article</a>
        <a href="/logout" class="btn btn-danger">Se deconnecter</a>
    </div>

    <!-- Message de succès -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Date de publication</th>
                <th>Date de modification</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($projets as $projet): ?>
                <tr>
                    <td><?php echo $projet->getId(); ?></td>
                    <td><?php echo $projet->getTitle(); ?></td>
                    <td>
                        <?php
                            echo $projet->getCreatedAt()->format('d.m.Y');
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $projet->getUpdatedAt()->format('d.m.Y');
                        ?>
                    </td>
                    <td>
                        <a href="/edit?id=<?php echo $projet->getId(); ?>" class="btn btn-light btn-sm">Editer</a>
                        <a
                            href="/delete?id=<?php echo $projet->getId(); ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');"
                        >
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php $content = ob_get_clean(); ?>