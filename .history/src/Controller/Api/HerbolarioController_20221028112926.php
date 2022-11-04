<?php

namespace App\Controller\Api;

use App\Entity\Herbolario;
use App\Repository\HerbolarioRepository;
use App\Repository\InfocomercialRepository;
use App\Services\Manager;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
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
    }

    #[Route('/edit_get/{id}',name:'api_edit_get_herbolario',methods:['GET', 'POST'])]
    public function edit_get(Request $request,int $id,EntityManagerInterface $entityManager, Manager $manager, HerbolarioRepository $herbolarioRepository): JsonResponse
    {
        $herbolario=$herbolarioRepository->findOneById($id);
        if(!$herbolario)
            throw $this->createNotFoundException('Herbolario not found');
        $dataResponse=['herbolario'=>$manager->object_to_array($herbolario)];

       if($request->getMethod()==='POST'){
            $data_received=json_Decode($request->getContent()); //$request->getContent devuelve en 1 json el contenido del post
            $save_operation=$manager->save($data_received,$herbolario);
            if($save_operation['error'])
                $dataResponse = ['status' => 500, 'response' => 'fail','method'=>'POST', 'herbolario' => null];
            else
                $dataResponse=['status'=>200,'response'=>'success', 'method'=>'POST','herbolario'=>$manager->object_to_array($save_operation['entity'])];
  
        }

            return $this->json($dataResponse,200);
        
    }

    #[Route('/delete/{id}', name: 'api_herbolario_delete', methods: ['DELETE'])]
    public function delete(HerbolarioRepository $herbolarioRepository,InfocomercialRepository $infocomercialRepository, Manager $manager, int $id): JsonResponse
    {
        $herbolario=$herbolarioRepository->findOneById($id);
        if(!$herbolario)
            throw $this->createNotFoundException('Herbolario not found');
        
        try {
            $infocomercial_herbolario=$infocomercialRepository->findByHerbolarioid($herbolario);
            foreach($infocomercial_herbolario as $herbolario_row)
                $manager->delete($herbolario_row,$infocomercialRepository);
            $manager->delete($herbolario,$herbolarioRepository);
            $status = 200;
            $response = 'success';
        } catch (\Exception $exception) {
            $status = 500;
            $response = $exception->getMessage();
        }
        return $this->json([
            'status' => $status,
            'response' => $response,
        ], 200);
        
    }


    #[Route('/new', name: 'api_herbolario_new', methods: ['GET'])]
    public function new(HerbolarioRepository $herbolarioRepository,Herbolario Manager $manager): JsonResponse
    {
        $herbolarios=$herbolarioRepository->findAll();
        $herbolarios_array= $manager->object_to_array($herbolarios);
        return $this->json(['herbolarios'=>$herbolarios_array],200);
    }

}
