<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/28/15
 * Time: 1:25 PM
 */

namespace Acme\Bundle\ReviewBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;


class ApiController extends FOSRestController
{
    /**
     * List all notes.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getMoviesAction($title)
    {
        $moviesHandler = $this->get('acme_review.movies.handler');
        $data = $moviesHandler->findMovie($title);
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }

}