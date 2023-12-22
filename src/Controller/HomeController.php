<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;

use App\Repository\ProjetRepository;

class HomeController extends AbstractController{

    /**
     * Page d'accueil
     */
    public function index():void{
        $projets = new ProjetRepository();

        // require_once '../templates/home/index.php';
        $this->view('home/index.php', ['projets' => $projets->getAll()]);
    }

    public function projet():void{
        // Si aucun paramètre ID ou que celui-ci est vide, redirection vers la page d'accueil
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
            $this->view('home/projet.php', ['projet' => $projet]);
        }
    }

    /**
     * Page de test
     */
    public function test(): void
    {
        $projets = new ProjetRepository();

        // require_once '../templates/home/index.php';
        $this->view('home/test.php', ['projets' => $projets->getAll()]);
    }

    public function contact(): void
    {
        $error = null;
        $success = null;
        // Si une méthode POST est reçue
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage des données
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $email = htmlspecialchars(strip_tags($_POST['email']));
            $message = htmlspecialchars(strip_tags($_POST['message']));

            // Vérifie si tous les champs sont remplis
            if (!empty($name) && !empty($email) && !empty($message)) {

                // Vérifie si le mail est valide
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    // Envoi de l'email avec PHPMailer
                    // Connecter au SMTP de MailTrap
                    $phpmailer = new PHPMailer();
                    $phpmailer->isSMTP();
                    $phpmailer->Host = $_ENV['MAIL_SMTP'];
                    $phpmailer->SMTPAuth = true;
                    $phpmailer->Port = $_ENV['MAIL_PORT'];
                    $phpmailer->Username = $_ENV['MAIL_USER'];
                    $phpmailer->Password = $_ENV['MAIL_PASS'];

                    // Envoi du mail
                    $phpmailer->setFrom($email, $name); // Expéditeur
                    $phpmailer->addAddress($_ENV['USER_EMAIL'], $_ENV['USER_NAME']); // Destinataire
                    $phpmailer->Subject = 'Message du formulaire de contact';
                    $phpmailer->Body = $message;

                    // Envoyer le mail
                    if ($phpmailer->send()) {
                        $success = 'Votre message a bien été envoyé !';
                    } else {
                        // $error = "Votre message n'a pu être envoyé. Veuillez ré-essayer !";
                        $error = $phpmailer->ErrorInfo;
                    }
                } else {
                    $error = 'Votre adresse email est invalide';
                }
            } else {
                $error = 'Veuillez remplir tous les champs';
            }
        }

        // Affichage du template
        $this->view('home/contact.php', [
            'success' => $success,
            'error' => $error
        ]);
    }
}
?>