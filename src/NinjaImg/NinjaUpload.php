<?php
namespace NinjaImg;

use Pecee\Http\Rest\RestBase;

class NinjaUpload extends RestBase {

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
     * @throws NinjaException
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

            throw new NinjaException($error, $code);
        }

        return $response;
    }

    /**
     * Alias for upload method.
     *
     * @param string $fileContents Binary content of file
     * @param string $destinationPath Full destination path including extension
     * @return string Returns url for upload on ImgNinja
     * @throws NinjaException
     */
    public function update($fileContents, $destinationPath) {
        return $this->upload($fileContents, $destinationPath);
    }

    /**
     * Delete file
     *
     * @param string $path
     * @return bool
     * @throws NinjaException
     */
    public function delete($path) {
        $this->httpRequest->addHeader('X-Auth-Token: ' . $this->apiToken);

        // Parse full url
        if($path[0] !== '/') {
            $url = parse_url($path);
            $path = $url['path'];
        }

        $response = json_decode($this->api($path, self::METHOD_DELETE)->getResponse());

        if(!$response || isset($response->error) && $response->error) {
            throw new NinjaException($response->error, $response->code);
        }

        return true;
    }

    public function api($url = null, $method = self::METHOD_GET, array $data = array()) {
        try {
            return parent::api($url, $method, $data);
        }catch (\Exception $e) {
            throw new NinjaException($e->getMessage(), $e->getCode());
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
