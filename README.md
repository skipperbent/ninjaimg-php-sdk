# ninjaimg-php-sdk
Official PHP SDK for the NinjaImg service


## Uploading file

```php
$image = new \NinjaImg\ServiceUpload($ninjaImgDomain, $ninjaImgApiToken);
$content = file_get_contents('/path/to/my/image.jpg');
$newUrl = $image->upload($content, '/destination/path/file.jpg');
```

## Deleting file

```php
$image = new \NinjaImg\ServiceUpload($ninjaImgDomain, $ninjaImgApiToken);
$response = $image->delete('/test/dement-mand.jpg');
```

## Generating url

```php
$url = new \NinjaImg\ServiceImage('http://local.service.ninjaimg/1914109_142926756975_2647065_n.jpg');

return $url->height(200)->width(200)->getUrl();
```
