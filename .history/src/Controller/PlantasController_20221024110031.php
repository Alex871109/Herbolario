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
        for($i=1;$i<4;$i++){
            $usos_array[$i]=new Usos();
            $herbolario_array[$i]=new Herbolario();
            $infocomercial_array[$i]=new Infocomercial();
        }
        if($request->getMethod()==='POST'){
            $planta_nombre=$request->Request->get('nombre');
            $planta_especie=$request->Request->get('especie');
            $planta_lugar=$request->Request->get('lugar');
            // $usos_array[0]=$request->Request->get('uso1');
            // $usos_array[1]=$request->Request->get('uso2');
            // $usos_array[2]=$request->Request->get('uso3');
            
            for($i=1;$i<4;$i++){
                $nombre_uso=$request->Request->get('uso'.$i);
                $usos_array[$i]=$usosRepository->findbyNombre($nombre_uso);
                $nombre_herbolario=$request->Request->get('herbolario'.$i);
                $herbolario_array[$i]=$herbolarioRepository->findbyNombre($nombre_herbolario);
                // $usos_array[$i]->setNombre($request->Request->get('uso'.$i));
                // $herbolario_array[$i]->setNombre($request->Request->get('herbolario'.$i));
                $infocomercial_array[$i]->setPrecio((float)$request->Request->get('precio'.$i));
                $infocomercial_array[$i]->setHerbolarioid($herbolario_array[$i]->getId());
                $infocomercial_array[$i]->setPlantaid($planta->getId());
                $entityManager->persist()
                $planta->addUso($usos_array[$i]);
                
            }
            $planta->setNombre($planta_nombre);
            $planta->setEspecie($planta_especie);
            $planta->setLugar($planta_lugar);
        }
        return $this->render('plantas/plantas_nueva.html.twig', [
            'accion' => false,
            'usos'=>$usos,
            'herbolarios'=>$herbolarios
        ]);
    }
}
