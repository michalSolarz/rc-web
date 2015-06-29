<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/29/15
 * Time: 9:30 AM
 */

namespace Acme\Bundle\ReviewBundle\Model;


class ImdbSuggestParser implements RawDataParserInterface
{

    private $rawData;
    private $parameter;
    private $clearedString;
    private $films = array();

    public function __construct($rawData)
    {
        $this->rawData = $rawData;
    }

    public function setParameter($parameter)
    {
        $this->parameter = $parameter;
    }

    public function clearString()
    {
        $temp = str_replace(array('imdb$'.$this->parameter.'(', ')'), '', $this->rawData);
        $temp2 = json_decode($temp);
        $this->clearedString = $temp2->d;
    }

    public function getCleared()
    {
        return json_decode($this->clearedString, true);
    }

    public function filterForFilms()
    {
        foreach ($this->clearedString as $position) {
            if (property_exists($position, 'y')) {
                array_push($this->films, $position);
            }
        }
    }

    public function getFilms()
    {
        $filmsArrays = array();
        foreach ($this->films as $film) {
            array_push($filmsArrays, get_object_vars($film));
        }

        return $filmsArrays;
    }
}