<?php

namespace App\Controller;

use App\Entity\Herbolario;
use App\Entity\Planta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlantasController extends AbstractController
{
    #[Route('/plantas/nueva', name: 'app_plantas_nueva')]
    public function nueva(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planta=new Planta();
        if($request->getMethod()==='POST'){
            $nombre=$request-Request-
        }
        return $this->render('plantas/plantas_nueva.html.twig', [
            'controller_name' => 'PlantasController',
        ]);
    }
}
