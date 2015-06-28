<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/28/15
 * Time: 1:25 PM
 */

namespace Acme\Bundle\ReviewBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;


class ApiController extends FOSRestController
{
    public function getMoviesAction($title)
    {
        $moviesHandler = $this->get('acme_review.movies.handler');
        $data = $moviesHandler->findMovie($title);
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }
}