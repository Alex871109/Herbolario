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
            $nombre=$request->Request->get('nombre');
            $especie=$request->Request->get('especie');
            $lugar=$request->Request->get('lugar');
            // $usos_array[0]=$request->Request->get('uso1');
            // $usos_array[1]=$request->Request->get('uso2');
            // $usos_array[2]=$request->Request->get('uso3');
            
            for($i=1;$i<4;$i++){
                $usos_array[$i]->setNombre($request->Request->get('uso'.$i));
                $herbolario_array[$i]->setNombre($request->Request->get('herbolario'.$i));
                $infocomercial_array[$i]->setPrecio((float)$request->Request->get('precio'.$i));
                $infocomercial_array[$i]->Set
            }
            // $herbolario_array[0]=$request->Request->get('herbolario1');
            // $$herbolario_array[1]=$request->Request->get('herbolario2');
            // $$herbolario_array[2]=$request->Request->get('herbolario3');
            $precio_array[0]=$request->Request->get('precio1');
            $precio_array[1]=$request->Request->get('precio2');
            $precio_array[2]=$request->Request->get('precio3');
            $planta->setNombre($nombre);
            $planta->setEspecie($especie);
            $planta->setLugar($lugar);
            foreach($usos_array as $uso)
                $planta->addUso($uso);

        }
        return $this->render('plantas/plantas_nueva.html.twig', [
            'accion' => false,
            'usos'=>$usos,
            'herbolarios'=>$herbolarios
        ]);
    }
}
