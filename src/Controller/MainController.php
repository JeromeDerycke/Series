<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home(){
        return $this->render("main/home.html.twig");
    }

    /**
     * @Route("/test", name="main_test")
     */
    public function test(){
        $serie = [
            "title"=>"Game of Thrones",
            "year"=>2021
        ];
        return $this->render("main/test.html.twig", [
            "mySerie"=>$serie,
            "autreVar"=>123456
        ]);
    }

    /**
     * @Route("/error", name="main_error")
     */
    public function error(){
        return $this->render("main/error404.html.twig");
    }

}