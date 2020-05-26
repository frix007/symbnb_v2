<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {


    /** 
     * @Route("/toto/{prenom}/age/{age}", name="toto")
     * @Route("/toto", name="toto_base")
     * @Route("/toto/{prenom}", name="test_prenom")
     * 
     * Montre la page qui dit Bonjour
     * 
     * @return void
    */
    public function toto($prenom = "anonyme", $age = 0) {
        return $this->render(
            'toto.html.twig',
            [ 
                'prenom' => "Jean-Yves",
                'age' => 41,
            ]
        );
    }

    /** 
     * @Route("/", name="homepage")
    */
    public function home(){
        $prenoms = ["Lior" =>12, "Joseph"=>25, "Anne"=>41];
        
        return $this->render(
            'home.html.twig',
            [ 
                'title' => "Bonjour à vous tous",
                'age' => 12,
                'tableau' => $prenoms
            ]
        );
    }
}

?>