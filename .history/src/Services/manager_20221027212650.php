<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

Class Manager
{
    private $entityManager;
    private $normalizer;
    private $reflectionClass;

    public function __construct(EntityManagerInterface $entityManager,NormalizerInterface $normalizer)
    {
        $this->entityManager=$entityManager;
        $this->normalizer=$normalizer;

    }


    public function save($data,$entity)
    {
        $error=false;
        foreach($data as $key=>$value){
            $method='set'.ucfirst($key);
            dump($meth)
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

    public function delete($entity,$repository)
    {
        $repository->remove($entity);
        $this->entityManager->flush();

    }

    public function object_to_array($entity)
    {
        return $this->normalizer->normalize($entity);

    }

    public function dismount($object)
    {
        $reflection= new \ReflectionClass(\get_class($object));
        $array = [];
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }

        return $array;
    }

}




?>