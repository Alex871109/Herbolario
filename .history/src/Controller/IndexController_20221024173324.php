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
        
        foreach($plantas as $indice=> $planta){
            $info_comercial_array[$indice]=$infocomercialRepository->findByPlantaid($planta);
            array_sort($info_comercial_array, 'precio', SORT_ASC)
        }
        dump($info_comercial_array);
        die();
       
        return $this->render('index/index.html.twig', [
            'plantas' => $plantas,
        ]);
    }
}
