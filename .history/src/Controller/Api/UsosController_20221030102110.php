<?php

namespace App\Controller\Api;

use App\Entity\Usos;
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



#[Route('/Api/usos')]
class UsosController extends AbstractController
{
    #[Route('/index', name: 'api_usos_index', methods: ['GET'])]
    public function index(UsosRepository $usosRepository, Manager $manager): JsonResponse
    {
        // $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        // $normalizer = new ObjectNormalizer($classMetadataFactory);
        // $serializer = new Serializer([$normalizer]);
         $usos=$usosRepository->findAll();
        $usos_array= $manager->object_to_array($usos,'basic');
    //    $usos_array= $serializer->normalize($usos, null, ['groups' => 'basic']);

        return $this->json(['usos'=>$usos_array],200);
    }


}
