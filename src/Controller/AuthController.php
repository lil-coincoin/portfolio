<?php

namespace App\Controller;

use App\Repository\UsersRepository;

class AuthController extends AbstractController{

    public function connexion():void{
        // Initialisation des erreurs à NULL
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier si le formulaire est complet
            if (!empty($_POST['username']) && !empty($_POST['password'])) {

                // Nettoyer les donnes issues du formulaire
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $password = htmlspecialchars(strip_tags($_POST['password']));

                $user = new UsersRepository;

                $user = $user->findUser($username);

                if ($user && password_verify($password, $user->getPassword())) {
                    // Stocker les infos de l'utilisateur en session
                    $_SESSION['user'] = $user;

                    // Redirection
                    header('Location: /admin');
                    exit;
                } else {
                    $error = 'Identifiants invalides';
                }
            } else {
                $error = 'Tous les champs sont obligatoires';
            }

            // Gestion de nos erreurs
            if ($error !== null) {
                // Déclaration d'une session contenant l'erreur
                $_SESSION['error'] = $error;

                $this->view('admin/login.php');
                exit;
            }
        }
        $this->view('admin/login.php');
    }

    public function disconnect():void{
        // Destruction de la session "user"
        unset($_SESSION['user']);

        // Redirection vers le formulaire de connexion
        header('Location: /');
    }
}
?>