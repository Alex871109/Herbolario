<?php

namespace App\Controller;

use App\Repository\InfocomercialRepository;
use App\Repository\PlantaRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $entityMI, PlantaRepository $pr, InfocomercialRepository $infocomercialRepository): Response
    {
        $plantas=$pr->findAll();
        dump($plantas[0])
        
        foreach($plantas as $indice=>$planta){
            $info_comercial_array=$infocomercialRepository->findByPlantaid($planta);
            dump($info_comercial_array);
            foreach($info_comercial_array as $infocomercial){
                $precio=$infocomercial->getPrecio();
                $herbolario=$infocomercial->getHerbolarioid();
                $array_ordenar_precio[$precio]=$herbolario;
            }
            ksort( $array_ordenar_precio);
            $herbolarios[$indice]=array_shift($array_ordenar_precio);
        }
        
       
       
        return $this->render('index/index.html.twig', [
            'plantas' => $plantas,
            'herbolarios'=>$herbolarios,
        ]);
    }
}
