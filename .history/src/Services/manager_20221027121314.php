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
       $data_as_array=$normalizer
        

    }




}




?>