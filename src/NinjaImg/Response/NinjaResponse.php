<?php

namespace NinjaImg\Response;

use Pecee\Http\HttpResponse;

class NinjaResponse
{

    protected $domain;
    protected $response;
    protected $httpResponse;

    public function __construct($domain, array $response)
    {
        $this->domain = $domain;
        $this->response = $response;
    }

    /**
     * Get the absolute url without scheme - most compatible.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->response['url'];
    }

    /**
     * Get the full absolute url.
     *
     * @return string
     */
    public function getUrlAbsolute()
    {
        return sprintf('https://%s%s', $this->domain, $this->getUrlRelative());
    }

    /**
     * @return string|null
     */
    public function getUrlRelative()
    {
        return $this->response['url_relative'];
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->response['domain'];
    }

    /**
     * Get information about the file
     *
     * @return FileDetails
     */
    public function getFileDetails()
    {
        return new FileDetails($this->response['file_details']);
    }

    /**
     * Get response array
     * @return array
     */
    public function toArray()
    {
        return [
            'url'          => $this->getUrl(),
            'url_absolute' => $this->getUrlAbsolute(),
            'url_relative' => $this->getUrlRelative(),
            'file_details' => $this->getFileDetails()->toArray(),
        ];
    }

    /**
     * Get http response
     *
     * @return HttpResponse
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * Set raw http response
     *
     * @param HttpResponse $response
     * @return static $this
     */
    public function setHttpResponse(HttpResponse $response)
    {
        $this->httpResponse = $response;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getUrl();
    }

}