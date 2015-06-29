<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/29/15
 * Time: 9:29 AM
 */

namespace Acme\Bundle\ReviewBundle\Model;


interface RawDataParserInterface
{
    public function __construct($rawData);
}