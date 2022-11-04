<?php

namespace App\Controller;

use App\Entity\Herbolario;
use App\Entity\Infocomercial;
use App\Entity\Planta;
use App\Entity\Usos;
use App\Repository\HerbolarioRepository;
use App\Repository\UsosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlantasController extends AbstractController
{
    #[Route('/plantas/nueva', name: 'app_plantas_nueva')]
    public function nueva(Request $request,UsosRepository $usosRepository,HerbolarioRepository $herbolarioRepository, EntityManagerInterface $entityManager): Response
    {
        $planta=new Planta();
        $infocomercial=new Infocomercial();
        $usos=$usosRepository->findAll();
        $herbolarios=$herbolarioRepository->findAll();
        dump($usos);
        dump($usos);
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
            $precio2=$request->Request->get('precio2');
            $precio3=$request->Request->get('precio3');
        }
        return $this->render('plantas/plantas_nueva.html.twig', [
            'accion' => false,
            'usos'=>$usos,
            'herbolarios'=>$herbolarios
        ]);
    }
}
