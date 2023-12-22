<?php

namespace App\Entity;

class Projet{

    private int $id;
    private string $title;
    private string $description;
    private string $preview;
    private string $createdAt;
    private string $updatedAt;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of preview
     */ 
    public function getPreview()
    {
        return (!file_exists($_ENV['FOLDER_PROJECT'].$this->preview)) ? 'default.png': $this->preview;
    }

    /**
     * Retourne le chemin complet de l'image du projet
     */
    public function getFolderPreview(){
        return $_ENV['FOLDER_PROJECT'].$this->getPreview();
    }

    /**
     * Set the value of preview
     *
     * @return  self
     */ 
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s',$this->createdAt);
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updateAt
     */ 
    public function getUpdatedAt()
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s',$this->updatedAt);
    }

    /**
     * Set the value of updateAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updateAt)
    {
        $this->updatedAt = $updateAt;

        return $this;
    }
}

?>