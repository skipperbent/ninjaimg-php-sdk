<?php

namespace NinjaImg\Test;

use NinjaImg\NinjaText;

class ServiceNinjaText extends TestCase
{

    public function testText()
    {
        $text = new NinjaText($this->ninjaDomain);

        $text->text('Hello world');

        $url = $text->textFont('Arial')->textSize('30')->getUrl();

        $this->assertTrue(count($url) > 0);
    }

}
