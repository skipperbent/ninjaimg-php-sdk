<?php
require 'auth.php';

class ServiceUploadTest extends PHPUnit_Framework_TestCase
{

    public function testUpload()
    {
        $image = new \NinjaImg\NinjaUpload(NINJAIMG_DOMAIN, NINJAIMG_API_TOKEN);
        $content = file_get_contents(__DIR__ . '/funny.jpg');
        $response = $image->upload($content, '/debug/funny-picture.jpg');

        $this->assertTrue(strpos($response, '//') === 0);
    }

    public function testDelete()
    {
        $image = new \NinjaImg\NinjaUpload(NINJAIMG_DOMAIN, NINJAIMG_API_TOKEN);
        $status = $image->delete('/debug/funny-picture.jpg');

        $this->assertTrue($status);
    }

}
