<?php

namespace App\Controller\Api;

use App\Entity\Usos;
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



#[Route('/Api/planta')]
class PlantaController extends AbstractController
{
    #[Route('/index', name: 'api_planta_index', methods: ['GET'])]
    public function index(PlantaRepository $plantaRepository, Manager $manager): JsonResponse
    {
        $plantas=$plantaRepository->findAll();
        $plantas_array= $manager->object_to_array($plantas,'form_planta');
        return $this->json(['plantas'=>$plantas_array],200);
    }

    #[Route('/edit_get/{id}',name:'api_edit_get_planta',methods:['GET', 'POST'])]
    public function edit_get(Request $request,int $id,EntityManagerInterface $entityManager, Manager $manager, PlantaRepository $plantaRepository): JsonResponse
    {
        $planta=$plantaRepository->findOneById($id);
        if(!$planta)
            throw $this->createNotFoundException('Planta not found');
        $dataResponse=['planta'=>$manager->object_to_array($planta,'form_planta')];
        dump($planta);
        dump($manager->object_to_array($planta,'form_planta')); 
       if($request->getMethod()==='POST'){
            $data_received=json_Decode($request->getContent()); //$request->getContent devuelve en 1 json el contenido del post
            // dump($data_received); die;
            $save_operation=$manager->save($data_received,$planta);
            if($save_operation['error'])
                $dataResponse = ['status' => 500, 'response' => 'fail','method'=>'POST', 'uso' => null];
            else
                $dataResponse=['status'=>200,'response'=>'success', 'method'=>'POST','planta'=>$manager->object_to_array($save_operation['entity'],'form_planta')];
        }
            return $this->json($dataResponse,200);
        
    }

    #[Route('/delete/{id}', name: 'api_planta_delete', methods: ['DELETE'])]
    public function delete(PlantaRepository $plantaRepository, Info Manager $manager, int $id): JsonResponse
    {
        $planta=$plantaRepository->findOneById($id);
        if(!$planta)
            throw $this->createNotFoundException('Planta not found');
        
        try {
            $usos_from_planta=$planta->getUso();
            foreach($usos_from_planta as $uso)
                $planta->removeUso($uso);
            
            $manager->update();
            $manager->delete($planta,$plantaRepository);
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

    // #[Route('/new', name: 'api_usos_new', methods: ['POST'])]
    // public function new(UsosRepository $herbolarioRepository,Request $request, Manager $manager): JsonResponse
    // {
    //     $uso=new Usos();
    //     $data_received=json_Decode($request->getContent());
    //     $save_operation=$manager->save($data_received,$uso);
    //         if($save_operation['error'])
    //             $dataResponse = ['status' => 500, 'response' => 'fail'];
    //         else
    //             $dataResponse = ['status' => 200, 'response' => 'success', 'new herbolario'=> $save_operation['entity']];

    //     return $this->json($dataResponse,200);
    // }


}
