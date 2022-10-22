<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HerbolarioController extends AbstractController
{
    #[Route('/herbolario', name: 'app_herbolario')]
    public function index(): Response
    {
        return $this->render('herbolario/index.html.twig', [
            'controller_name' => 'HerbolarioController',
        ]);
    }
}
