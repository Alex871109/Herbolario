<?php

namespace App\Controller;

use App\Entity\Herbolario;
use App\Entity\Infocomercial;
use App\Entity\Planta;
use App\Entity\Usos;
use App\Repository\HerbolarioRepository;
use App\Repository\PlantaRepository;
use App\Repository\UsosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlantasController extends AbstractController
{
    #[Route('/plantas/nueva', name: 'app_plantas_nueva')]
    public function nueva(Request $request,UsosRepository $usosRepository,HerbolarioRepository $herbolarioRepository,PlantaRepository $plantaRepository, EntityManagerInterface $entityManager): Response
    {
        $planta=new Planta();
        $usos=$usosRepository->findAll();
        $herbolarios=$herbolarioRepository->findAll();
        if($request->getMethod()==='POST'){
            $planta_nombre=$request->request->get('nombre');
            if($planta_nombre===$plantaRepository->findOneBy(['nombre'=>$planta_nombre])->getNombre()){
                throw $this->createAccessDeniedException("La planta '$planta_nombre' ya esta registrada");
                return $this->redirectToRoute('app_plantas_nueva');
            }


            $planta_especie=$request->request->get('especie');
            $planta_lugar=$request->request->get('lugar');
            $planta->setNombre($planta_nombre);
            $planta->setEspecie($planta_especie);
            $planta->setLugar($planta_lugar);
            $entityManager->persist( $planta);
            for($i=1;$i<4;$i++){
                $nombre_uso[$i]=$request->request->get('uso'.$i);
                $nombre_herbolario[$i]=$request->request->get('herbolario'.$i);
            }
            if($nombre_uso[1]===$nombre_uso[2]||$nombre_uso[1]===$nombre_uso[3]||$nombre_uso[2]===$nombre_uso[3]){
                
            }
            
            for($i=1;$i<4;$i++){
                $usos_array[$i]=new Usos();
                $herbolario_array[$i]=new Herbolario();
                $infocomercial_array[$i]=new Infocomercial();
                $usos_array[$i]=$usosRepository->findOneBy(['nombre' =>$nombre_uso]);// Si no lo pongo explisito , piensa que devuelve mas de 1 valor, o sea 1 array             
                $herbolario_array[$i]=$herbolarioRepository->findOneBy(['nombre' =>$nombre_herbolario]); //Si no hago el findOneBy ve como q devuelve 1 array y luego no deja usar ->getId()
                $infocomercial_array[$i]->setPrecio((float)$request->request->get('precio'.$i));
                $infocomercial_array[$i]->setHerbolarioid($herbolario_array[$i]);
                $infocomercial_array[$i]->setPlantaid($planta);
                $entityManager->persist( $infocomercial_array[$i]);
                $planta->addUso($usos_array[$i]);
                $entityManager->flush();
            }
            
            $this->redirectToRoute('app_index');
        }
        return $this->render('plantas/plantas_nueva.html.twig', [
            'accion' => false,
            'usos'=>$usos,
            'herbolarios'=>$herbolarios
        ]);
    }
}
