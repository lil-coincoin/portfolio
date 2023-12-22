<?php
namespace App\Controller;

use App\Controller\AbstractController;

use App\Repository\ProjetRepository;
use App\Entity\Projet;
use App\Service\UploadService;

class AdminController extends AbstractController{

    /**
     * Si l'utilisateur n'est pas connecté, on le redirige
     * vers le formulaire de connexion
     */
    public function __construct()
    {
        if(!$this->isUserLoggedIn()){
            header('Location: /login');
            exit;
        }
        $this->layout = "admin_layout.php";
    }

    public function admin():void{
        $projets = new ProjetRepository();
        $this->view('admin/index.php', ['projets' => $projets->getAll()]);
        exit;
    }

    public function deleteProject():void{
        $projet = new ProjetRepository();
        $projetSelect = $projet->getById($_GET['id']);

        // Erreur 404 ?
        if (!$projetSelect) {
            header('Location: /404');
            exit;
        }
        $projet->delete($projetSelect);
        header('Location: /admin');
        exit;
    }

    public function edit():void{
        if (empty($_GET['id'])) {
            header('Location: /404');
            exit;
        }else{
            $projet = new ProjetRepository();
            $projet = $projet->getById($_GET['id']);
            // Aucun projet n'a été trouvé
            if (!$projet) {
                header('Location: /404');
                exit;
            }
            $this->view('admin/edit.php', ['projet' => $projet]);
        }
    }

    public function update():void{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer et nettoyer les données
            $id = $_GET['id'];
            $title = htmlspecialchars(strip_tags($_POST['title']));
            $desc = htmlspecialchars(strip_tags($_POST['desc']));

            $projet = new ProjetRepository();
            $projetSelect = $projet->getById($_GET['id']);

            // Vérifier si les champs sont complétés
            if (!empty($title) && !empty($desc)) {

                //Upload de l'image de preview
                $uploadService = new UploadService;
                $preview = $uploadService->upload($_FILES['preview']);

                // Vérifie si un upload doit être fait
                if (isset($_FILES['preview']) && $_FILES['preview']['error'] === UPLOAD_ERR_OK) {

                    $typeExt = [
                        'png' => 'image/png',
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'webp' => 'image/webp',
                    ];
        
                    $sizeMax = 1 * 1024 * 1024;
                    $extension = strtolower(pathinfo($_FILES['preview']['name'], PATHINFO_EXTENSION));
        
                    // Vérifier si le fichier est bien une image autorisée
                    if (array_key_exists($extension, $typeExt) && in_array($_FILES['preview']['type'], $typeExt)) {
        
                        // Vérifie si le poids de l'image ne dépasse pas la limite fixée
                        if ($_FILES['preview']['size'] <= $sizeMax) {
        
                            // Supprime l'ancienne image
                            if (file_exists($projetSelect->getFolderPreview())) {
                                // Supprime l'image à l'endroit indiqué
                                unlink($projetSelect->getFolderPreview());
                            }
        
                            // Renomme le nom de l'image
                            $slugify = new \Cocur\Slugify\Slugify();
                            $newName = $slugify->slugify($projetSelect->getTitle().$projetSelect->getId());
                            $cover = "$newName.$extension";
        
                            // Télécharge la nouvelle image sous le nouveau nom
                            move_uploaded_file(
                                $_FILES['preview']['tmp_name'],
                                $_ENV['FOLDER_PROJECT'].$cover
                            );

                            $projetSelect->setPreview($cover);
                        } else {
                            $_SESSION['error'] = "L'image ne doit pas dépasser les 1Mo";
                            header("Location: /edit?id=$id");
                            exit;
                        }
                    } else {
                        $_SESSION['error'] = "Le fichier n'est pas une image conforme";
                        header("Location: /edit?id=$id");
                        exit;
                    }
                }

                $projetSelect->setTitle($title);
                $projetSelect->setDescription($desc);
                $projetSelect->setUpdatedAt((new \DateTime('now'))->format('Y-m-d H:i:s'));
                $projet->update($projetSelect);
        
                // Message de succès
                $_SESSION['success'] = 'Les modifications ont bien été prise en compte';
        
            } else {
                $_SESSION['error'] = 'Le titre et le contenu est obligatoire';
            }
        
            // Redirection vers le formulaire d'édition
            header("Location: /edit?id=$id");
            exit;
        
        } else {
            header('Location: /admin');
            exit;
        }
    }

    public function add():void{
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage des données
            $title = htmlspecialchars(strip_tags($_POST['title']));
            $description = htmlspecialchars(strip_tags($_POST['desc']));

            // Vérifie si tous est bien rempli
            if (
                !empty($title) &&
                !empty($description) &&
                $_FILES['preview']['error'] === UPLOAD_ERR_OK
            ) {
                // Upload de l'image de preview
                $uploadService = new UploadService();
                $preview = $uploadService->upload($_FILES['preview']);

                if ($preview) {
                    // Date du jour
                    $date = new \DateTime();

                    // Créer un objet avec l'entité "Projet"
                    $projet = new Projet();
                    $projet->setTitle($title);
                    $projet->setDescription($description);
                    $projet->setPreview($preview);
                    $projet->setCreatedAt($date->format('Y-m-d H:i:s'));
                    $projet->setUpdatedAt($date->format('Y-m-d H:i:s'));

                    $projetRepository = new ProjetRepository();
                    $projetRepository->add($projet);

                    $success = 'Votre nouveau projet est enregistré';
                } else {
                    $error = 'Le fichier est invalide';
                }
            } else {
                $error = 'Tous les champs sont obligatoires';
            }
        }

        $this->view('admin/add.php', [
            'error' => $error,
            'success' => $success
        ]);
    }
}

?>