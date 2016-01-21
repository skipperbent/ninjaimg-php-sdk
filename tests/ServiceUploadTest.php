<?php

class ServiceUploadTest extends PHPUnit_Framework_TestCase  {

    const NINJAIMG_DOMAIN = 'local.service2.ninjaimg';
    const NINJAIMG_API_TOKEN = 'B51099F3BE3747569B0EAD286DB5CF6C';

	public function testUpload() {

		$image = new \NinjaImg\NinjaUpload(self::NINJAIMG_DOMAIN, self::NINJAIMG_API_TOKEN);
		$content = file_get_contents('funny.jpg');
		$response = $image->upload($content, '/test/funny-picture.jpg');

        $response = @json_decode($response, true);

        $this->assertTrue(isset($response['url']));
	}

	public function testDelete() {
        $image = new \NinjaImg\NinjaUpload(self::NINJAIMG_DOMAIN, self::NINJAIMG_API_TOKEN);
        $response = $image->delete('/test/funny-picture.jpg');

        $response = @json_decode($response, true);

        $this->assertTrue(isset($response['success']));
	}

}
