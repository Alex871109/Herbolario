<?php

namespace App\Services;

use App\Entity\Planta;
use App\Entity\Usos;
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
                    // dump($value);
                    // dump($attr);
                     foreach($value as $key =>$element){
                         $obj_array[]=$this->array_to_object($element,'form_planta',$entity);

                        // $uso=new Usos($element);
                        dump($uso);die;

                            $entity->$addmethod($element);
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
    return $serializer->denormalize($array,Usos::class,null,['groups' =>$groups]);
    
    }

}




?>