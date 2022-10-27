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
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/Api/herbolario')]
class HerbolarioController extends AbstractController
{
    #[Route('/index', name: 'app_herbolario_index', methods: ['GET'])]
    public function index(HerbolarioRepository $herbolarioRepository, SerializerInterface $serializer): JsonResponse
    {
        
        $herbolarios=$herbolarioRepository->findAll();
        $herbolarios= $Serializer->se
        dump($herbolarios);
        die();
    }

    #[Route('/herbolario/{id}/eliminar',name:'app_eliminar_herbolario')]
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
