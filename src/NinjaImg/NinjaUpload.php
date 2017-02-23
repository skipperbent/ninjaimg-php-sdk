<?php
namespace NinjaImg;

use Pecee\Http\Rest\RestBase;

class NinjaUpload extends RestBase
{
    protected $disableHttps = false;
    protected $domain;
    protected $apiToken;

    public function __construct($domain, $apiToken)
    {
        $this->domain   = $domain;
        $this->apiToken = $apiToken;

        parent::__construct();
    }

    public function getServiceUrl()
    {
        return (($this->disableHttps === true) ? 'http' : 'https') . '://' . $this->domain . '/api';
    }

    /**
     * @param string $fileContents Binary content of file
     * @param string $destinationPath Full destination path including extension
     *
     * @return string Returns url for upload on ImgNinja
     * @throws NinjaException
     */
    public function upload($fileContents, $destinationPath)
    {

        $this->httpRequest->setHeaders([
            'X-Auth-Token: ' . $this->apiToken,
        ]);

        $this->httpRequest->setRawPostData($fileContents);

        return $this->api($destinationPath, self::METHOD_POST)->url;
    }

    /**
     * Alias for upload method.
     *
     * @param string $fileContents Binary content of file
     * @param string $destinationPath Full destination path including extension
     *
     * @return string Returns url for upload on ImgNinja
     * @throws NinjaException
     */
    public function update($fileContents, $destinationPath)
    {
        return $this->upload($fileContents, $destinationPath);
    }

    /**
     * Delete file
     *
     * @param string $path
     *
     * @return bool
     * @throws NinjaException
     */
    public function delete($path)
    {
        $this->httpRequest->addHeader('X-Auth-Token: ' . $this->apiToken);

        // Parse full url
        if ($path[0] !== '/') {
            $url  = parse_url($path);
            $path = $url['path'];
        }

        $this->api($path, static::METHOD_DELETE);

        return true;
    }

    /**
     * Delete multiple files
     *
     * @param array $paths
     *
     * @return bool
     * @throws NinjaException
     */
    public function deleteBatch(array $paths)
    {
        $this->httpRequest->addHeader('X-Auth-Token: ' . $this->apiToken);
        $this->httpRequest->setRawPostData(json_encode($paths));

        return $this->api('/batch', static::METHOD_DELETE);
    }

    public function api($url = null, $method = self::METHOD_GET, array $data = array())
    {
        $httpResponse = null;

        try {
            $httpResponse = parent::api($url, $method, $data);

            $response = json_decode($httpResponse->getResponse());

            if ($response === null || $response === false || (isset($response->error) && $response->error)) {

                $error = isset($response->error) ? $response->error : 'Invalid response';
                $code  = isset($response->code) ? $response->code : $httpResponse->getStatusCode();

                throw new NinjaException($error, $code, $httpResponse);
            }

            return $response;

        } catch (\Exception $e) {
            throw new NinjaException($e->getMessage(), $e->getCode(), $httpResponse);
        }
    }

    /**
     * Disable https
     * @return static
     */
    public function setDisableHttps()
    {
        $this->disableHttps = true;
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
