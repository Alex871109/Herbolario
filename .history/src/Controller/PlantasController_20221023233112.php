<?php

namespace App\Controller;

use App\Entity\Herbolario;
use App\Entity\Infocomercial;
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
        $infocomercial=new Infocomercial();
        if($request->getMethod()==='POST'){
            $nombre=$request->Request->get('nombre');
            $especie=$request->Request->get('especie');
            $lugar=$request->Request->get('lugar');
            $uso1=$request->Request->get('uso1');
            $uso2=$request->Request->get('uso2');
            $uso3=$request->Request->get('uso3');
            $herbolario1=$request->Request->get('herbolario1');
            $herbolario2=$request->Request->get('herbolario2');
            $herbolario3=$request->Request->get('herbolario3');
            $precio1=$request->Request->get('precio1');
        }
        return $this->render('plantas/plantas_nueva.html.twig', [
            'controller_name' => 'PlantasController',
        ]);
    }
}
