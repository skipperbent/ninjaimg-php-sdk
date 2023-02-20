<?php

namespace NinjaImg;

use Exception;
use NinjaImg\Response\NinjaResponse;
use Pecee\Http\HttpResponse;
use Pecee\Http\Rest\RestBase;

class NinjaUpload extends RestBase
{
    const ENDPOINT_URL = '/api/v1';

    protected bool $disableHttps = false;
    protected string $domain;
    protected string $apiToken;

    public function __construct($domain, $apiToken)
    {
        $this->domain = $domain;
        $this->apiToken = $apiToken;

        parent::__construct();
    }

    public function getServiceUrl(): string
    {
        return sprintf(
            '%s://%s%s',
            $this->disableHttps === true ? 'http' : 'https',
            $this->domain,
            static::ENDPOINT_URL);
    }

    /**
     * Upload file by url
     *
     * @param string $url
     * @param string $destinationPath
     *
     * @return NinjaResponse
     * @throws NinjaException
     */
    public function uploadByUrl(string $url, string $destinationPath): NinjaResponse
    {
        $this->httpRequest->setHeaders([
            'X-Auth-Token: ' . $this->apiToken,
        ]);

        $this->httpRequest->setContentType('application/x-www-form-urlencoded');

        return new NinjaResponse($this->domain, $this->api($destinationPath, static::METHOD_POST, ['url' => $url])->getResponseArray());
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
    public function upload(string $fileContents, string $destinationPath): NinjaResponse
    {
        $this->httpRequest->setHeaders([
            'X-Auth-Token: ' . $this->apiToken,
        ]);

        $this->httpRequest->setRawPostData($fileContents);

        return new NinjaResponse($this->domain, $this->api($destinationPath, static::METHOD_POST)->getResponseArray());
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
    public function convertVideo(string $fileContents, string $destinationPath, ?string $outputFormat = null): NinjaResponse
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

        return new NinjaResponse($this->domain, $this->api($destinationPath, static::METHOD_POST)->getResponseArray());
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
    public function update(string $fileContents, string $destinationPath): NinjaResponse
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
    public function delete(string $path): array
    {
        $this->httpRequest->addHeader('X-Auth-Token: ' . $this->apiToken);

        // Parse full url
        if ($path[0] !== '/') {
            $path = parse_url($path, PHP_URL_PATH);
        }

        return $this->api($path, static::METHOD_DELETE)->getResponseArray();
    }

    /**
     * Delete multiple files
     *
     * @param array $paths
     *
     * @return array
     * @throws NinjaException
     */
    public function deleteBatch(array $paths): array
    {
        $this->httpRequest->addHeader('X-Auth-Token: ' . $this->apiToken);
        $this->httpRequest->setRawPostData(json_encode($paths));

        return $this->api('/batch', static::METHOD_DELETE)->getResponseArray();
    }

    /**
     * Execute api
     *
     * @param string|null $url
     * @param string $method
     * @param array $data
     *
     * @return HttpResponse
     * @throws NinjaException
     */
    public function api(?string $url = null, string $method = self::METHOD_GET, array $data = []): HttpResponse
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

        } catch (Exception $e) {
            throw new NinjaException($e->getMessage(), $e->getCode(), $httpResponse);
        }
    }

    /**
     * Disable https
     *
     * @param bool $value
     * @return static
     */
    public function setDisableHttps(bool $value = true): self
    {
        $this->disableHttps = $value;

        return $this;
    }

    /**
     * Returns full domain name for you app on ImgNinja
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Full domain name for your apps domain on ImgNinja
     *
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

}
