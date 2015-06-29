<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/29/15
 * Time: 7:47 AM
 */

namespace Acme\Bundle\ReviewBundle\Model;


interface cUrlGrabberInterface
{
    public function __construct($baseUrl, $parameter, array $headers = null);

    public function getResults();
}