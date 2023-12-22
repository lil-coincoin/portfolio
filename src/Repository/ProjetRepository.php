<?php

namespace App\Repository;

use App\Entity\Projet;
use Core\Database;

/**
 * ProjetRepository.php
 */

class ProjetRepository extends Database{

    private $instance;

    public function __construct()
    {
        $this->instance = self::getInstance();
    }

    /**
     * Insertion en BDD
     */
    public function add(Projet $projet): Projet{
        $query = $this->instance->prepare("
            INSERT INTO projets (title, description, preview, created_at, updated_at)
            VALUES (:title, :description, :preview, :created_at, :updated_at)
        ");

        $query->bindValue(':title', $projet->getTitle());
        $query->bindValue(':description', $projet->getDescription());
        $query->bindValue(':preview', $projet->getPreview());
        $query->bindValue(':created_at', $projet->getCreatedAt()->format('Y-m-d H:i:s'));
        $query->bindValue(':updated_at', $projet->getUpdatedAt()->format('Y-m-d H:i:s'));
        $query->execute();

        //Recupere l'ID nouvellement créé 
        $id = $this->instance->lastInsertId();

        //Ajoute l'ID à mon objet
        $projet->setId($id);

        return $projet;
    }


    public function getAll(): array{
        $objectsProjects = [];
        $query = $this->instance->query("SELECT * FROM projets ORDER BY created_at DESC");
        $projects = $query->fetchAll();

        foreach ($projects as $project) {
            $item = new Projet();
            $item->setId($project->id);
            $item->setTitle($project->title);
            $item->setDescription($project->description);
            $item->setPreview($project->preview);
            $item->setCreatedAt($project->created_at);
            $item->setUpdatedAt($project->updated_at);

            $objectsProjects[] = $item;
        }

        return $objectsProjects;
    }

    public function getById(int $id): Projet | null{
        $item = null;
        $query = $this->instance->prepare("
            SELECT *
            FROM projets
            WHERE projets.id = :id
        ");

        $query->bindValue(':id', $id);
        $query->execute();

        $projet = $query->fetch();

        if($projet) {
            $item = new Projet();
            $item->setId($projet->id);
            $item->setTitle($projet->title);
            $item->setDescription($projet->description);
            $item->setPreview($projet->preview);
            $item->setCreatedAt($projet->created_at);
            $item->setUpdatedAt($projet->updated_at);
        }

        return $item;
    }

    public function delete(Projet $projet):void{
        $query = $this->instance->prepare("DELETE FROM projets WHERE id = :id");
        $query->bindValue(':id', $projet->getId());
        $query->execute();
    }

    public function update(Projet $projet):void{
        $query = $this->instance->prepare("UPDATE projets SET title = :title, description = :description, preview = :preview, created_at = :created_at, updated_at = :updated_at WHERE id = :id");
        $query->bindValue(':id', $projet->getId());
        $query->bindValue(':title', $projet->getTitle());
        $query->bindValue(':description', $projet->getDescription());
        $query->bindValue(':preview', $projet->getPreview());
        $query->bindValue(':created_at', $projet->getCreatedAt()->format('Y-m-d H:i:s'));
        $query->bindValue(':updated_at', $projet->getUpdatedAt()->format('Y-m-d H:i:s'));
        $query->execute();
    }
}

?>