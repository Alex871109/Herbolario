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


    public function save($id,$repository)
    {
        return $repository->findById($id);
        

    }




}




?>