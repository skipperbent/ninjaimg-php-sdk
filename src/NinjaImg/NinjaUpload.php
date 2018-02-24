<?php

namespace NinjaImg;

use NinjaImg\Response\NinjaResponse;
use Pecee\Http\Rest\RestBase;

class NinjaUpload extends RestBase
{
    protected $disableHttps = false;
    protected $domain;
    protected $apiToken;

    public function __construct($domain, $apiToken)
    {
        $this->domain = $domain;
        $this->apiToken = $apiToken;

        parent::__construct();
    }

    public function getServiceUrl()
    {
        return ($this->disableHttps === true ? 'http' : 'https') . '://' . $this->domain . '/api';
    }

    /**
     * Upload file to ninjaimg
     *
     * @param string $fileContents Binary content of file
     * @param string $destinationPath Full destination path including extension
     *
     * @return NinjaResponse Returns response object
     * @throws NinjaException
     */
    public function upload($fileContents, $destinationPath)
    {

        $this->httpRequest->setHeaders([
            'X-Auth-Token: ' . $this->apiToken,
        ]);

        $this->httpRequest->setRawPostData($fileContents);

        return new NinjaResponse($this->domain, $this->api($destinationPath, static::METHOD_POST));
    }

    /**
     * Upload and convert video.
     *
     * NinjaImg will convert the file to the format specified as extension in the $destinationPath parameter
     * unless another format has been specified using the $outputFormat parameter.
     *
     * @param string $fileContents Binary content of file
     * @param string $destinationPath Full destination path including extension
     * @param string|null $outputFormat Optional format you want the video converted to (mp3, mp4, avi etc.)
     *
     * @return NinjaResponse Returns response object
     * @throws NinjaException
     */
    public function convertVideo($fileContents, $destinationPath, $outputFormat = null)
    {

        $this->httpRequest->setHeaders([
            'X-Auth-Token: ' . $this->apiToken,
        ]);

        $this->httpRequest->setRawPostData($fileContents);

        $separator = strpos($destinationPath, '?') !== false ? '&' : '?';

        $destinationPath .= $separator . 'convert=true';

        if ($outputFormat !== null) {
            $destinationPath .= '&format=' . $outputFormat;
        }

        return new NinjaResponse($this->domain, $this->api($destinationPath, static::METHOD_POST));
    }

    /**
     * Alias for upload method.
     *
     * @param string $fileContents Binary content of file
     * @param string $destinationPath Full destination path including extension
     *
     * @return NinjaResponse Returns response object
     * @throws NinjaException
     */
    public function update($fileContents, $destinationPath)
    {
        return $this->upload($fileContents, $destinationPath);
    }

    /**
     * Delete single file
     *
     * @param string $path
     *
     * @return array
     * @throws NinjaException
     */
    public function delete($path)
    {
        $this->httpRequest->addHeader('X-Auth-Token: ' . $this->apiToken);

        // Parse full url
        if ($path[0] !== '/') {
            $path = parse_url($path, PHP_URL_PATH);
        }

        return $this->api($path, static::METHOD_DELETE);
    }

    /**
     * Delete multiple files
     *
     * @param array $paths
     *
     * @return array
     * @throws NinjaException
     */
    public function deleteBatch(array $paths)
    {
        $this->httpRequest->addHeader('X-Auth-Token: ' . $this->apiToken);
        $this->httpRequest->setRawPostData(json_encode($paths));

        return $this->api('/batch', static::METHOD_DELETE);
    }

    /**
     * Execute api
     *
     * @param string|null $url
     * @param string $method
     * @param array $data
     *
     * @return array
     * @throws NinjaException
     */
    public function api($url = null, $method = self::METHOD_GET, array $data = [])
    {
        $httpResponse = null;

        try {
            $this->httpRequest->setReturnHeader(false);

            $httpResponse = parent::api($url, $method, $data);

            $response = json_decode($httpResponse->getResponse(), true);

            if ($response === null || $response === false || isset($response['error']) === true) {

                $error = isset($response['error']) === true ? $response['error'] : 'Invalid response';
                $code = isset($response['code']) === true ? $response['code'] : $httpResponse->getStatusCode();

                throw new NinjaException($error, $code, $httpResponse);
            }

            return $response;

        } catch (\Exception $e) {
            throw new NinjaException($e->getMessage(), $e->getCode(), $httpResponse);
        }
    }

    /**
     * Disable https
     *
     * @param bool $value
     * @return static
     */
    public function setDisableHttps($value = true)
    {
        $this->disableHttps = $value;

        return $this;
    }

    /**
     * Returns full domain name for you app on ImgNinja
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Full domain name for your apps domain on ImgNinja
     *
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

}
