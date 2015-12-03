<?php

require_once '../vendor/autoload.php';

$url = new \NinjaImg\ServiceImage('http://local.service.ninjaimg/1914109_142926756975_2647065_n.jpg');

die($url->height(200)->width(200)->getUrl());


$image = new \NinjaImg\ServiceUpload('local.service.ninjaimg', 'B51099F3BE3747569B0EAD286DB5CF6C');
$content = file_get_contents('11705146_10155774660785543_5213892747026074050_n.jpg');
$response = $image->upload($content, '/test/dement-mand.jpg');

die(var_dump($image->delete('/test/dement-mand.jpg')));

die(var_dump($response));