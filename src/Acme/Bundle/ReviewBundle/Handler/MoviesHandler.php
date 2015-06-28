<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/28/15
 * Time: 1:53 PM
 */

namespace Acme\Bundle\ReviewBundle\Handler;


use Acme\Bundle\ReviewBundle\Model\MoviesHandlerInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MoviesHandler implements MoviesHandlerInterface
{
    private $objectManager;
    private $entityClass;
    private $repository;

    public function __construct(ObjectManager $objectManager, $entityClass)
    {
        $this->objectManager = $objectManager;
        $this->entityClass = $entityClass;
        $this->repository = $this->objectManager->getRepository($this->entityClass);
    }

    public function findMovie($title)
    {
        $query = $this->repository->createQueryBuilder('movies')
            ->where('movies.title LIKE :title')
            ->setParameter('title', '%'.$title.'%')
            ->getQuery();

        if (!$query->getResult()) {
            $url = "http://sg.media-imdb.com/suggests/a/".$title.".json";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $curlData = curl_exec($curl);
            curl_close($curl);
            $result = str_replace(array('imdb$'.$title.'(', ')'), '', $curlData);
            $json = json_decode($result);
            $array = $json->d;
            $finalArray = array();
            foreach ($array as $object) {
                if (property_exists($object, 'y')) {
                    array_push($finalArray, $object);
                }
            }
            var_dump($finalArray);
        } else {
            return $query->getResult();
        }
    }
}