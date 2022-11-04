<?php

namespace App\Controller\Api;

use App\Entity\Herbolario;
use App\Repository\HerbolarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HerbolarioController extends AbstractController
{
    #[Route('/Api/herbolario', name: 'app_herbolario1')]
    public function index(HerbolarioRepository $herbolarioRepository)
    {
        
        $herbolarios=$herbolarioRepository->findAll();
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
