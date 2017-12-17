<?php

namespace NinjaImg\Test;

use NinjaImg\NinjaUpload;

class ServiceUploadTest extends TestCase
{
    protected $destinationPath = '/test/my-funny-picture.jpg';

    public function testUpload()
    {
        $ninja = new NinjaUpload($this->ninjaDomain, $this->ninjaApiToken);
        $ninja->setDisableHttps();

        $content = file_get_contents(dirname(dirname(__DIR__)) . '/resources/funny.jpg');
        $response = $ninja->upload($content, $this->destinationPath);

        $this->assertEquals($response, '//' . $this->ninjaDomain . $this->destinationPath);
    }

    public function testDelete()
    {
        $ninja = new NinjaUpload($this->ninjaDomain, $this->ninjaApiToken);
        $ninja->setDisableHttps();

        $response = $ninja->delete($this->destinationPath);

        $this->assertTrue(isset($response['success']));
    }

}
