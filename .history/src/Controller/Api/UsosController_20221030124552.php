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
         $usos=$usosRepository->findAll();
        $usos_array= $manager->object_to_array($usos,'basic');
        return $this->json(['usos'=>$usos_array],200);
    }

    #[Route('/edit_get/{id}',name:'',methods:['GET', 'POST'])]
    public function edit_get(Request $request,int $id,EntityManagerInterface $entityManager, Manager $manager, HerbolarioRepository $herbolarioRepository): JsonResponse
    {
        $herbolario=$herbolarioRepository->findOneById($id);
        if(!$herbolario)
            throw $this->createNotFoundException('Herbolario not found');
        $dataResponse=['herbolario'=>$manager->object_to_array($herbolario,'basic')];

       if($request->getMethod()==='POST'){
            $data_received=json_Decode($request->getContent()); //$request->getContent devuelve en 1 json el contenido del post
            $save_operation=$manager->save($data_received,$herbolario);
            if($save_operation['error'])
                $dataResponse = ['status' => 500, 'response' => 'fail','method'=>'POST', 'herbolario' => null];
            else
                $dataResponse=['status'=>200,'response'=>'success', 'method'=>'POST','herbolario'=>$manager->object_to_array($save_operation['entity'],'basic')];
  
        }

            return $this->json($dataResponse,200);
        
    }


}
