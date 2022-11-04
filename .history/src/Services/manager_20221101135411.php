<?php

namespace App\Services;

use App\Entity\Planta;
use App\Entity\Usos;
use App\Repository\UsosRepository;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Serializer;

Class Manager
{
    private $entityManager;
    private $normalizer;
    private $reflectionClass;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;

    }


    public function save($data,$entity)
    {
        $error=false;
        foreach($data as $key=>$value){
            $attr=ucfirst($key);
            if('Id'!==$attr){           //El Id nunca debe modificarse
                $setmethod='set'.$attr;
                $addmethod='add'.$attr;
                if(method_exists($entity,$setmethod))
                    $entity->$setmethod($value); 
                elseif(method_exists($entity,$addmethod)){
                    foreach($obj->getUsos() as $obj_antiguo)
                    
                     $clase="App\Entity\\".$attr.'s';           //Fablico la direccion a Usos
                     foreach($value as $element){               //Aqui Value es el array de objetos usos
                        $id=$element->id;                       // elemento id almacenado en cada objeto
                        $repository=$this->entityManager->getRepository($clase);  //repositorio de la entity en value, en este caso  UsosRepository
                        $obj=$repository->findOneById($id);
                        
                        $entity->$addmethod($obj);
                      }                     
                } 
                else
                    $error=true; 
            }           
        }
        if(!$error){
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
        else
            $entity='';
        
        return  ['error'=>$error,'entity'=>$entity];   

    }


    public function update()
    {
        $this->entityManager->flush();

    }


    public function delete($entity,$repository)
    {
        $repository->remove($entity);
        $this->entityManager->flush();

    }

    public function object_to_array($entity,$groups)
    {
    $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
    $normalizer = new ObjectNormalizer($classMetadataFactory);
    $serializer = new Serializer([$normalizer]);
    return $serializer->normalize($entity, null, ['groups' => $groups]);
    
    }

    public function array_to_object($array,$groups,$entity)
    {
    $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
    $normalizer = new ObjectNormalizer($classMetadataFactory);
    $serializer = new Serializer([$normalizer]);
    dump($array);
    return $serializer->denormalize($array,Usos::class,null);
    
    }

}




?>