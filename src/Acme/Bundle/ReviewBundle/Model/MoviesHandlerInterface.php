<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/28/15
 * Time: 1:58 PM
 */

namespace Acme\Bundle\ReviewBundle\Model;


use Doctrine\Common\Persistence\ObjectManager;

interface MoviesHandlerInterface
{
    public function __construct(ObjectManager $objectManager, $entityClass);

    public function findMovie($title);
}