<?php

namespace App\Controller\Api;

use Exception;
use App\Entity\Usos;
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
class UsosController extends AbstractController
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

    


}