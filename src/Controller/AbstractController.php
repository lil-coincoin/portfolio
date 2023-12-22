<?php

namespace App\Controller;

use App\Entity\Users;

abstract class AbstractController
{
    /**
     * Verifie si l'utilisateur est connecté
     */
    protected function isUserLoggedIn():bool{
        return isset($_SESSION['user']);
    }
    /**
     * Permet d'afficher une vue
     */
    protected function view(string $path, array $vars = []): void
    {
        $vars['isLoggedIn'] = $this->isUserLoggedIn();
        /**
         * Extrait les clés comme des variables et leur affecte comme valeur
         * la valeur de la clé du tableau
         */
        extract($vars);
        // Si le template existe, on l'affiche
        if (file_exists("../templates/$path")) {
            require_once "../templates/$path";
            require __DIR__ . "../../../templates/layout.php";
            return;
        }

        throw new \Exception("Le template \"$path\" n'existe pas");
    }
}

?>