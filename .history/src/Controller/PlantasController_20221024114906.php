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
        $usos=$usosRepository->findAll();
        $herbolarios=$herbolarioRepository->findAll();
        if($request->getMethod()==='POST'){
            $planta_nombre=$request->request->get('nombre');
            $planta_especie=$request->request->get('especie');
            $planta_lugar=$request->request->get('lugar');
            // $usos_array[0]=$request->Request->get('uso1');
            // $usos_array[1]=$request->Request->get('uso2');
            // $usos_array[2]=$request->Request->get('uso3');
            
            for($i=1;$i<4;$i++){
                $usos_array[$i]=new Usos();
                $herbolario_array[$i]=new Herbolario();
                $infocomercial_array[$i]=new Infocomercial();

                $nombre_uso=$request->request->get('uso'.$i);
                $usos_array[$i]=$usosRepository->findByNombre($nombre_uso);
                $nombre_herbolario=$request->request->get('herbolario'.$i);
                $herbolario_array[$i]=$herbolarioRepository->findByNombre($nombre_herbolario);
                dump($herbolario_array[$i]);
                //die();
                // $usos_array[$i]->setNombre($request->Request->get('uso'.$i));
                // $herbolario_array[$i]->setNombre($request->Request->get('herbolario'.$i));
                $infocomercial_array[$i]->setPrecio((float)$request->request->get('precio'.$i));
                $herbolario_id=$herbolario_array[$i];
                $infocomercial_array[$i]->setHerbolarioid($herbolario_id);
                $infocomercial_array[$i]->setPlantaid($planta->getId());
                $entityManager->persist( $infocomercial_array[$i]);
                $entityManager->flush();
                $planta->addUso($usos_array[$i]);
                
            }
            $planta->setNombre($planta_nombre);
            $planta->setEspecie($planta_especie);
            $planta->setLugar($planta_lugar);
            $entityManager->persist( $planta);
            $entityManager->flush();
            $this->redirectToRoute('app_index');
        }
        return $this->render('plantas/plantas_nueva.html.twig', [
            'accion' => false,
            'usos'=>$usos,
            'herbolarios'=>$herbolarios
        ]);
    }
}
