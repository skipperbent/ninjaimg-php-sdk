<?php
require 'auth.php';

class ServiceUploadTest extends PHPUnit_Framework_TestCase
{

    public function testUpload()
    {
        $text = new \NinjaImg\NinjaText(NINJAIMG_DOMAIN);

        $text->text('Hello world');
        echo $text->textFont('Arial')->textSize('30')->getUrl();
    }

}
