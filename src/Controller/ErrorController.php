<?php

namespace App\Controller;

class ErrorController extends AbstractController{

    public function error404():void{
        $this->view('errors/404.php');
        
    }
}
?>