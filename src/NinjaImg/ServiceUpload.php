<?php
namespace NinjaImg;

use Pecee\Http\Rest\RestBase;

class ServiceUpload extends RestBase {

    protected $domain;
    protected $apiToken;

    public function __construct($domain, $apiToken) {
        $this->domain = $domain;
        $this->apiToken = $apiToken;
        parent::__construct();

        $this->serviceUrl = 'http://' . $domain;
    }

    /**
     * @param string $fileContents Binary content of file
     * @param string $destinationPath Full destination path including extension
     * @return string Returns url for upload on ImgNinja
     * @throws ServiceException
     */
    public function upload($fileContents, $destinationPath) {
        $info = new \finfo(FILEINFO_MIME);
        $mime = $info->buffer($fileContents, FILEINFO_MIME_TYPE);

        $this->httpRequest->setHeaders([
            'X-Auth-Token: ' . $this->apiToken,
            'Content-type: ' . $mime
        ]);

        $this->httpRequest->setRawPostData($fileContents);

        $response = json_decode($this->api($destinationPath, self::METHOD_POST)->getResponse());

        if ($response === null || isset($response->error) && $response->error) {

            $error = isset($response->error) ? $response->error : 'Invalid response';
            $code = isset($response->code) ? $response->code : 0;

            throw new ServiceException($error, $code);
        }

        return $response->url;
    }

    /**
     * Alias for upload method.
     *
     * @param string $fileContents Binary content of file
     * @param string $destinationPath Full destination path including extension
     * @return string Returns url for upload on ImgNinja
     * @throws ServiceException
     */
    public function update($fileContents, $destinationPath) {
        return $this->upload($fileContents, $destinationPath);
    }

    /**
     * Delete file
     *
     * @param string $path
     * @return bool
     * @throws ServiceException
     */
    public function delete($path) {
        $this->httpRequest->addHeader('X-Auth-Token: ' . $this->apiToken);

        $response = json_decode($this->api($path, self::METHOD_DELETE)->getResponse());

        if(!$response || isset($response->error) && $response->error) {
            throw new ServiceException($response->error, $response->code);
        }

        return true;
    }

    public function api($url = null, $method = self::METHOD_GET, array $data = array()) {
        try {
            return parent::api($url, $method, $data);
        }catch (\Exception $e) {
            throw new ServiceException($e->getMessage(), $e->getCode());
        }
    }
    /**
     * Returns full domain name for you app on ImgNinja
     * @return string
     */
    public function getDomain() {
        return $this->domain;
    }

    /**
     * Full domain name for your apps domain on ImgNinja
     * @param string $domain
     */
    public function setDomain($domain) {
        $this->domain = $domain;
    }

}
