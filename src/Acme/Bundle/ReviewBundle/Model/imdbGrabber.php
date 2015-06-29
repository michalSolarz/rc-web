<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 6/29/15
 * Time: 7:54 AM
 */

namespace Acme\Bundle\ReviewBundle\Model;


class imdbGrabber implements cUrlGrabberInterface
{
    private $cUrl;
    private $baseUrl;
    private $parameter;
    private $headers = array();
    private $urlFiller;
    private $targetUrl;
    private $results;

    public function __construct($baseUrl, $parameter, array $headers = null)
    {
        $this->initcUrl();
        $this->baseUrl = $baseUrl;
        $this->parameter = $parameter;
        $this->headers = $headers;
        $this->setupHeaders();
        $this->createTargetUrl();
    }

    private function initcUrl()
    {
        $this->cUrl = curl_init();
        curl_setopt($this->cUrl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->cUrl, CURLOPT_RETURNTRANSFER, 1);
    }

    private function setupHeaders()
    {
        curl_setopt(
            $this->cUrl,
            CURLOPT_HTTPHEADER,
            $this->headers
        );
    }

    private function createTargetUrl()
    {
        $this->cutString();
        $this->targetUrl = $this->baseUrl.$this->urlFiller.$this->parameter.'.json';
    }

    private function cutString()
    {
        if (strlen($this->parameter) > 1) {
            $this->urlFiller = substr($this->parameter, 0, 1);
        } else {
            $this->urlFiller = $this->parameter;
        }
        $this->urlFiller = $this->urlFiller.'/';
    }

    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    public function getResults()
    {
        curl_setopt($this->cUrl, CURLOPT_URL, $this->targetUrl);
        $this->results = curl_exec($this->cUrl);

        return $this->results;
    }

}