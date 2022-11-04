<?php

namespace App\Controller\Api;

use App\Entity\Herbolario;
use App\Repository\HerbolarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/Api/herbolario')]
class HerbolarioController extends AbstractController
{
    #[Route('/index', name: 'api_herbolario_index', methods: ['GET'])]
    public function index(HerbolarioRepository $herbolarioRepository, SerializerInterface $serializer, NormalizerInterface $normalizer): JsonResponse
    {
        
        $herbolarios=$herbolarioRepository->findAll();
        $herbolarios_array= $normalizer->normalize($herbolarios);
        return $this->json(['herbolarios'=>$herbolarios_array],200);
        // dump($herbolarios);
        // dump($herbolarios_array);
        // die();
    }

    #[Route('/edit_get/{id}',name:'api_edit__herbolario')]
    public function eliminar(Herbolario $herbolario,Request $request,EntityManagerInterface $entityManager): Response
    {
        if($request->getMethod()==='POST'){
            $entityManager->remove($herbolario);
            $entityManager->flush();
            $this->addFlash('success','Herbolario correctamente eliminado');
            return $this->redirectToRoute('app_herbolario');

        }
     
    }


}
