<?php

use App\Controller;

/**
 * Permet de rediriger l'utilisateur selon une adresse personnalisée
 */
class Router
{
    private array $routes = [];

    public function dispatch(string $uri = '/'): void
    {
        // On enregistre la position du "?" dans l'URI s'il existe
        $position = strpos($uri, '?');

        /**
         * Si $position est égal à "true", on nettoie l'URI en retirant tout ce
         * qui se trouve après le "?"
         */
        if ($position) {
            /**
             * Ex : /details?id=5
             * Résultat : /details
             */
            $uri = substr($uri, 0, $position);
        }

        // Si l'URI est différent d'un simple slash, on continue le nettoyage
        if ($uri !== '/') {
            // Récupère le dernier caractère de mon URI
            $lastChar = substr($uri, -1);

            // Si le dernier caractère est un slash, on le retire
            if ($lastChar === '/') {
                // Retourne la chaine sans le dernier caractère
                $uri = substr($uri, 0, -1);
            }
        }

        // Si le tableau des routes n'est pas vide, alors on effectue une recherche
        if (!empty($this->routes)) {

            // Si la route existe dans la configuration, on charge le controller
            if (isset($this->routes[$uri])) {
                // list($controller, $method) = $this->routes[$uri];
                [$controller, $method] = $this->routes[$uri];

                //Ajout de l'espace de nom à mon controller
                $controller = "App\\Controller\\$controller";

                // Vérifie si la classe $controller existe
                if (class_exists($controller)) {

                    // Instanciation de la classe controller
                    $controllerInstance = new $controller();

                    // Si la méthode existe, on charge celle-ci
                    if (method_exists($controllerInstance, $method)) {
                        $controllerInstance->$method();
                        return;
                    }
                }
            }
        }

        // Force le code de retour à 404
        http_response_code(404);

        $errorInstance = new App\Controller\ErrorController();
        $errorInstance->error404();
    }

    /**
     * Permet d'ajouter une route personnalisée
     */
    public function add(string $route, string $controller, string $method): void
    {
        $this->routes[$route] = [$controller, $method];
    }
}
?>