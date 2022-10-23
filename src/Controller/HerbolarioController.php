<?php

namespace App\Controller;

use App\Entity\Herbolario;
use App\Repository\HerbolarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HerbolarioController extends AbstractController
{
    #[Route('/herbolario', name: 'app_herbolario')]
    public function index(HerbolarioRepository $herbolarioRepository): Response
    {
        
        $herbolarios=$herbolarioRepository->findAll();
        return $this->render('herbolario/herbolario_index.html.twig', [
            'herbolarios' => $herbolarios,
        ]);
    }

    #[Route('/herbolario/nuevo', name: 'app_nuevo_herbolario')]
    public function nuevo(Request $request, EntityManagerInterface $entityManager): Response
    {
        $herbolario= new Herbolario();
        if($request->getMethod()==='POST'){
            $nombre=$request->request->get('nombre');
            $url=$request->request->get('url'); 
            $nombre=trim($nombre);
            $url=trim($url);  
                if($nombre!="" && $url!=""){
                    $herbolario->setNombre($nombre);
                    $herbolario->setUrl($url);
                    $entityManager->persist($herbolario);
                    $entityManager->flush();
                    $this->addFlash('success','Herbolario correctamente añadido');
                }
                else
                    $this->addFlash('danger','Los campos no pueden estar en blanco');

            return $this->redirectToRoute('app_herbolario');

        }
        return $this->render('herbolario/herbolario_nuevo.html.twig', []);
    }



}
