<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/28/15
 * Time: 1:53 PM
 */

namespace Acme\Bundle\ReviewBundle\Handler;


use Acme\Bundle\ReviewBundle\Model\imdbGrabber;
use Acme\Bundle\ReviewBundle\Model\ImdbSuggestParser;
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
            $imdbGrabber = new imdbGrabber(
                'http://sg.media-imdb.com/suggests/',
                $title,
                array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8")
            );
            $imdbRawData = $imdbGrabber->getResults();
            $imdbSuggestParser = new ImdbSuggestParser($imdbRawData);
            $imdbSuggestParser->setParameter($title);
            $imdbSuggestParser->clearString();
            $imdbSuggestParser->filterForFilms();

            return $imdbSuggestParser->getFilms();
        } else {
            return $query->getResult();
        }
    }
}