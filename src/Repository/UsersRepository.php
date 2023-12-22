<?php

namespace App\Repository;

use App\Entity\Users;
use Core\Database;

/**
 * ProjetRepository.php
 */

class UsersRepository extends Database{

    private $instance;

    public function __construct()
    {
        $this->instance = self::getInstance();
    }

    /**
     * Insertion en BDD
     */
    public function add(Users $users): Users{
        $query = $this->instance->prepare("
            INSERT INTO users (username, password)
            VALUES (:username, :password)
        ");

        $query->bindValue(':username', $users->getUsername());
        $query->bindValue(':password', $users->getPassword());
        $query->execute();

        //Recupere l'ID nouvellement créé 
        $id = $this->instance->lastInsertId();

        //Ajoute l'ID à mon objet
        $users->setId($id);

        return $users;
    }

    public function findUser(string $username): Users | null{
        $item = null;
        $query = $this->instance->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindValue(':username', $username);
        $query->execute();

        $user = $query->fetch();

        if($user) {
            $item = new Users();
            $item->setId($user->id);
            $item->setUsername($user->username);
            $item->setPassword($user->password);
        }

        return $item;
    }
}

?>