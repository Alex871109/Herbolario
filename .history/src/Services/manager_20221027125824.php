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
        $data_array=$this->normalizer->normalize($data);
        $error=false;
        foreach($data_array as $key=>$value){
            $method='set.'.ucfirst($key);
            if(method_exists($entity,$method))
                $entity->$method($value);            
            else
                $error=true;            
        }
        if(!$error)
            $this->$entityManager->flush
        
        

    }




}




?>