# ninjaimg-php-sdk
Official PHP SDK for the NinjaImg service

## Installing the SDK

Add the latest version of the NinjaImg SDK, add the following lines to your ```composer.json``` file.

```php
{
    "require": {
        "pecee/ninjaimg/php-sdk": "1.*"
    },
    "require-dev": {
        "pecee/ninjaimg/php-sdk": "1.*"
    }
}
```

## Uploading file

```php
$image = new \NinjaImg\ServiceUpload($ninjaImgDomain, $ninjaImgApiToken);
$content = file_get_contents('/path/to/my/image.jpg');
$newUrl = $image->upload($content, '/destination/path/file.jpg');
```

## Deleting file

```php
$image = new \NinjaImg\ServiceUpload($ninjaImgDomain, $ninjaImgApiToken);
$response = $image->delete('/destination/path/file.jpg');
```

## Generating url

```php
$url = new \NinjaImg\ServiceImage('http://example.ninjaimg.com/destination/path/file.jpg');

return $url->height(200)->width(200)->getUrl();
```

#### Response

```
http://example.ninjaimg.com/destination/path/file.jpg?h=200&w=200
```
