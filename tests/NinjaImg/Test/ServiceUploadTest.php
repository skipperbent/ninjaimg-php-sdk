<?php

namespace NinjaImg\Test;

use NinjaImg\NinjaUpload;
use NinjaImg\Response\NinjaResponse;

class ServiceUploadTest extends TestCase
{
    protected $destinationPath = '/test/my-funny-picture.jpg';

    public function testUpload()
    {
        $ninja = new NinjaUpload($this->ninjaDomain, $this->ninjaApiToken);
        $ninja->setDisableHttps();

        $filePath = dirname(dirname(__DIR__)) . '/resources/funny.jpg';
        $content = file_get_contents($filePath);
        $response = $ninja->upload($content, $this->destinationPath);

        $this->assertInstanceOf(NinjaResponse::class, $response);

        $this->assertEquals([
            'url'          => sprintf('//%s%s', $this->ninjaDomain, $this->destinationPath),
            'url_absolute' => sprintf('https://%s%s', $this->ninjaDomain, $this->destinationPath),
            'url_relative' => $this->destinationPath,
            'file_details' => [
                'name'      => basename($this->destinationPath),
                'size_kb'   => round(strlen($content) / 1024),
                'mime'      => mime_content_type($filePath),
                'extension' => pathinfo(basename($filePath), PATHINFO_EXTENSION),
            ],
        ], $response->toArray());

        $this->assertEquals($response, '//' . $this->ninjaDomain . $this->destinationPath);
    }

    public function testDelete()
    {
        $ninja = new NinjaUpload($this->ninjaDomain, $this->ninjaApiToken);
        $ninja->setDisableHttps();

        $response = $ninja->delete($this->destinationPath);

        $this->assertTrue(isset($response['success']) ? $response['success'] : false);
    }

}
