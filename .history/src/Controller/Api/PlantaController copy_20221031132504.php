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
class UsosController extends AbstractController
{
    #[Route('/index', name: 'api_planta_index', methods: ['GET'])]
    public function index(PlantaRepository $plantaRepository, Manager $manager): JsonResponse
    {
         $plantas=$plantaRepository->findAll();
        $plantas_array= $manager->object_to_array($usos,'basic');
        return $this->json(['usos'=>$usos_array],200);
    }

    #[Route('/edit_get/{id}',name:'api_edit_get_usos',methods:['GET', 'POST'])]
    public function edit_get(Request $request,int $id,EntityManagerInterface $entityManager, Manager $manager, UsosRepository $usosRepository): JsonResponse
    {
        $uso=$usosRepository->findOneById($id);
        if(!$uso)
            throw $this->createNotFoundException('Uso not found');
        $dataResponse=['uso'=>$manager->object_to_array($uso,'basic')];

       if($request->getMethod()==='POST'){
            $data_received=json_Decode($request->getContent()); //$request->getContent devuelve en 1 json el contenido del post
            $save_operation=$manager->save($data_received,$uso);
            if($save_operation['error'])
                $dataResponse = ['status' => 500, 'response' => 'fail','method'=>'POST', 'uso' => null];
            else
                $dataResponse=['status'=>200,'response'=>'success', 'method'=>'POST','uso'=>$manager->object_to_array($save_operation['entity'],'basic')];
  
        }

            return $this->json($dataResponse,200);
        
    }

    #[Route('/delete/{id}', name: 'api_usos_delete', methods: ['DELETE'])]
    public function delete(UsosRepository $usosRepository,PlantaRepository $plantaRepository, Manager $manager, int $id): JsonResponse
    {
        $uso=$usosRepository->findOneById($id);
        if(!$uso)
            throw $this->createNotFoundException('Uso not found');
        
        try {
            $plantas=$plantaRepository->findByUso($uso); //Metodo mio, no de symfony
            foreach($plantas as $planta)
               $planta->removeUso($uso);
            $manager->update();
            $manager->delete($uso,$usosRepository);
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

    #[Route('/new', name: 'api_usos_new', methods: ['POST'])]
    public function new(UsosRepository $herbolarioRepository,Request $request, Manager $manager): JsonResponse
    {
        $uso=new Usos();
        $data_received=json_Decode($request->getContent());
        $save_operation=$manager->save($data_received,$uso);
            if($save_operation['error'])
                $dataResponse = ['status' => 500, 'response' => 'fail'];
            else
                $dataResponse = ['status' => 200, 'response' => 'success', 'new herbolario'=> $save_operation['entity']];

        return $this->json($dataResponse,200);
    }


}
