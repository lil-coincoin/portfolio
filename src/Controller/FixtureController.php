<?php

namespace App\Controller;

use Faker;

use App\Entity\Projet;
use App\Entity\Users;
use App\Repository\ProjetRepository;
use App\Repository\UsersRepository;

/**
 * Genere des faussses données pour le développement
 */
class FixtureController extends AbstractController{
    public function index():void{

        $faker = Faker\Factory::create();
        $projetRepository = new ProjetRepository();

        for ($i=0; $i < 10 ; $i++) { 
            //Créer un objet avec l'entité "Projet"
            $projet = new Projet();
            $projet->setTitle($faker->sentence);
            $projet->setDescription($faker->realText);
            $projet->setPreview('test.png');
            $projet->setCreatedAt($faker->dateTimeBetween('-2 years')->format('Y-m-d'));
            $projet->setUpdateAt($faker->dateTimeBetween('-1 years')->format('Y-m-d'));

            //Insérer en base de données
            $projetRepository->add($projet);
        }

        $usersRepository = new UsersRepository();
        for ($i=0; $i < 5 ; $i++) { 
            //Créer un objet avec l'entité "Users"
            $user = new Users();
            $user->setUsername($faker->userName);
            $user->setPassword(password_hash('secret', PASSWORD_DEFAULT));

            //Insérer en base de données
            $usersRepository->add($user);
        }

        $this->view('fixtures/index.php');
    }


}

?>