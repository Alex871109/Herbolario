<?php

namespace App\Controller\Api;

use App\Entity\Herbolario;
use App\Repository\HerbolarioRepository;
use App\Services\Manager;
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
    public function index(HerbolarioRepository $herbolarioRepository, Manager $manager): JsonResponse
    {
        
        $herbolarios=$herbolarioRepository->findAll();
        $herbolarios_array= $manager->object_to_array($herbolarios);
        return $this->json(['herbolarios'=>$herbolarios_array],200);
        // dump($herbolarios);
        // dump($herbolarios_array);
        // die();
    }

    #[Route('/edit_get/{id}',name:'api_edit_get_herbolario',methods:['GET', 'POST'])]
    public function edit_get(int $id,Request $request,EntityManagerInterface $entityManager, Manager $manager, HerbolarioRepository $herbolarioRepository): JsonResponse
    {
        // $data_received=$request;
        // dump($data_received);
        // die();
        
        
        $herbolario=$herbolarioRepository->findById($id);
        if(!$herbolario)
            throw $this->createNotFoundException('Herbolario not found');
        $dataResponse=['herbolario'=>$manager->object_to_array($herbolario)];
        dump($herbolario);
        dump($manager->object_to_array($herbolario)[0]);
    //    dump($manager->dismount($herbolario));
      //  die();
    //    if($request->getMethod()==='POST'){
    //         //$data_received=$request->request->all();
    //         $data_received=$request->request->get('Id');
    //         // $save_operation=$manager->save($data_received,$herbolario);
    //         // if($save_operation['error'])
    //         //     $dataResponse = ['status' => 500, 'response' => 'fail','method'=>'POST', 'herbolario' => null];
    //         // else
    //         //     $dataResponse=['status'=>200,'response'=>'success', 'method'=>'POST','herbolario'=>$manager->object_to_array($save_operation['entity'])];

    //         // return $this->json($dataResponse,200); 
            
    //         return $this->json($manager->object_to_array($data_received) ,200);   
    //     }

            return $this->json($dataResponse,200);
        
    }

    #[Route('/delete/{id}', name: 'api_herbolario_delete', methods: ['DELETE'])]
    public function delete(HerbolarioRepository $herbolarioRepository, Manager $manager, int $id): JsonResponse
    {
        $herbolario=$herbolarioRepository->findById($id);
        if(!$herbolario)
            throw $this->createNotFoundException('Herbolario not found');
        $manager->
        
    }


}
