<?php

namespace App\Controller\Api;

use App\Entity\Infocomercial;
use Exception;
use App\Entity\Usos;
use App\Repository\HerbolarioRepository;
use App\Repository\InfocomercialRepository;
use App\Repository\PlantaRepository;
use App\Repository\UsosRepository;
use App\Services\Manager;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;



#[Route('/api/infocomercial')]
class InfocomercialController extends AbstractController
{
    #[Route('/sortedbyplantprice', name: 'api_infocomercial_sortedbyplantprice', methods: ['GET'])]
    public function sortedbyplantprice(PlantaRepository $pr, InfocomercialRepository $infocomercialRepository,  Manager $manager): JsonResponse
    {
        $plantas=$pr->findAll();
        $herbolarios=[];
        foreach($plantas as $indice=>$planta){
            $info_comercial_array=$infocomercialRepository->findByPlantaid($planta);
            foreach($info_comercial_array as $infocomercial){
                $precio=$infocomercial->getPrecio();
                $herbolario=$infocomercial->getHerbolarioid();
                $array_ordenar_precio[$precio]=$herbolario;
            }
            ksort( $array_ordenar_precio);
            $herbolarios[$indice]=array_shift($array_ordenar_precio); 
        }
        $sortedbyplantprice= $manager->object_to_array($herbolarios,'basic');
        return $this->json(['herbolarios'=>$sortedbyplantprice],200);
    }

    #[Route('/new', name: 'api_infocomercial_new', methods: ['POST'])]
    public function new(PlantaRepository $plantaRepository,HerbolarioRepository $herbolarioRepository,   Request $request, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $infocomercials = json_decode($request->getContent(), true)['infocomercials'];
        dump($infocomercials);
        foreach ($infocomercials as $infocomercialData) {
            $infocomercial = new Infocomercial();
            $infocomercial->setPlantaid($plantaRepository->findOneBy(['nombre'=>$infocomercialData['planta_nombre']]));
            $infocomercial->setHerbolarioid($herbolarioRepository->findOneBy(['nombre'=>$infocomercialData['herbolario_nombre']]));
            $infocomercial->setPrecio($infocomercialData['precio']);
            $entityManagerInterface->persist($infocomercial);
        }
    
        $entityManagerInterface->flush();
        return $this->json('success',200);
     
    }


}