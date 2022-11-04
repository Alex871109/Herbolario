<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

Class Manager
{
    private $entityManager;
    private $normalizer;

    public function __construct(EntityManagerInterface $entityManager,NormalizerInterface $normalizer)
    {
        $this->entityManager=$entityManager;
        $this->normalizer=$normalizer;
    }


    public function save($data,$entity)
    {
       // $data_array=$this->normalizer->normalize($data);
        $error=false;
        foreach($data as $key=>$value){
            $method='set'.ucfirst($key);
            if(method_exists($entity,$method))
                $entity->$method($value);            
            else
                $error=true;            
        }
        if(!$error){
        //    $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
        else
            $entity='';
        
        return  ['error'=>$error,'entity'=>$entity];
        
        

    }

    public function object_to_array($entity)
    {
        return $this->normalizer->normalize($entity);

    }

    public function dismount($object)
    {
        $reflectionClass = new ReflectionClass(get_class($object));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }

        return $array;
    }

}




?>