<?php

namespace App\Controller;

use App\Entity\Herbolario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlantasController extends AbstractController
{
    #[Route('/plantas/nueva', name: 'app_plantas_nueva')]
    public function nueva(Herbolario $): Response
    {
        return $this->render('plantas/plantas_nueva.html.twig', [
            'controller_name' => 'PlantasController',
        ]);
    }
}
