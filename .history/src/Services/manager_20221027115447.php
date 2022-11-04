<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use Normalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

Class Manager
{
    private $entityManager;
    private $normalizer;

    public function __construct(EntityManagerInterface $entityManager,Normalizer)
    {
        $this->entityManager=$entityManager;

    }


    public function save($data,$entity)
    {
       forech
        

    }




}




?>