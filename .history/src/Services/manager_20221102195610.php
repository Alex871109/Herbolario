<?php

namespace App\Services;

use App\Entity\Infocomercial;
use App\Entity\Planta;
use App\Entity\Usos;
use App\Repository\HerbolarioRepository;
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
    private $herbolarioRepository;

    public function __construct(EntityManagerInterface $entityManager,HerbolarioRepository $herbolariorepo)
    {
        $this->entityManager=$entityManager;
        $this->herbolarioRepository=$herbolariorepo;

    }


    public function save($data,$entity)
    {
        $error=false;
        $mensaje='';
        foreach($data as $key=>$value){
            if($key==='nombre' &&$value===$entity->getNombre()){
                $error=true;
                $mensaje="El valor $value ya existe en $entity";
                break;
            }

            $attr=ucfirst($key);
            if('Herbolario'!==$attr){           //Herbolario como parte de planta se edita diferente
                $setmethod='set'.$attr;
                $addmethod='add'.$attr;
                if(method_exists($entity,$setmethod))
                    $entity->$setmethod($value); 
                elseif(method_exists($entity,$addmethod)){ 
                    $removemethod='remove'.$attr;
                    $getmethod='get'.$attr;
                    $attr_collection=$entity->$getmethod($attr);
                    foreach($attr_collection as $ac)    //Recorro los objetos actuales en la coleccion 
                        $entity->$removemethod($ac); //Elimino los usos en la coleccion Uso en esa planta
                    $clase="App\Entity\\".$attr.'s';           //Fablico la direccion a Usos
                    foreach($value as $element){               //Aqui Value es el array de objetos usos
                        $nombre=$element->nombre;           // elemento nombre almacenado en cada objeto
                        $repository=$this->entityManager->getRepository($clase);  //repositorio de la entity en value, en este caso  UsosRepository
                        $obj=$repository->findOneByNombre($nombre);     //Aqui tengo el objeto Uso especifico 
                        if(!$obj){
                            $error=true;
                            $mensaje="El objeto $nombre no existe en $clase";
                            break;
                        }
                        $entity->$addmethod($obj);
                      } 
                                       
                }
                else
                    $error=true; 
            }
            else{
                foreach ($value as $herbolario){
                    $nombre_herbolario=$herbolario->nombre;
                    $precio_herbolario=$herbolario->precio;
                    $herbolario_entity=$this->herbolarioRepository->findOneByNombre($nombre_herbolario);
                    if(!$herbolario_entity){
                        $error=true;
                        $mensaje="El herbolario  $value ya existe en $entity";
                        break;
                    }
                    $infocomercial=new Infocomercial();
                    $infocomercial->setHerbolarioid($herbolario_entity);
                    $infocomercial->setPlantaid($entity);
                    $infocomercial->setPrecio($precio_herbolario);
                    $this->entityManager->persist($infocomercial);
                }
            }           
        }
        if(!$error){
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
        else
            $entity='';
        
         return  ['error'=>$error,'entity'=>$entity, 'msg'=>$mensaje];   


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