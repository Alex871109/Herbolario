<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;

Class Manager
{
    private $entityManager;
    

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;

    }


    public function getById($id,$repo)
    {
        $mientity=$entity->repository->findById($id);
        dump($mientity);
        die();

    }




}




?>