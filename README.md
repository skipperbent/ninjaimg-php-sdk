# ninjaimg/php-sdk

Official PHP SDK for the NinjaImg service

## Installing the SDK

Add the latest version of the NinjaImg SDK by running the following command:

```
composer require ninjaimg/php-sdk
```

## Uploading file

```php
$image = new \NinjaImg\NinjaUpload($ninjaImgDomain, $ninjaImgApiToken);
$content = file_get_contents('/path/to/my/image.jpg');
$newUrl = $image->upload($content, '/destination/path/file.jpg');
```

## Deleting file

```php
$image = new \NinjaImg\NinjaUpload($ninjaImgDomain, $ninjaImgApiToken);
$response = $image->delete('/destination/path/file.jpg');
```

## Deleting multiple files

```php
$image = new \NinjaImg\NinjaUpload($ninjaImgDomain, $ninjaImgApiToken);
$response = $image->deleteBatch([
    '/destination/path/file1.jpg',
    '/destination/path/file2.jpg',
]);
```

## Generating url

```php
$url = new \NinjaImg\NinjaImage('http://example.ninjaimg.com/destination/path/file.jpg');

return $url->height(200)->width(200)->getUrl();
```

## Generating text

```php
$text = new \NinjaImg\NinjaText('example.ninjaimg.com');
$text->text('Hello world');

return $text->textFont('Arial')->getUrl();
```

#### Response

```
//example.ninjaimg.com/destination/path/file.jpg?h=200&w=200
```

## The MIT License (MIT)

Copyright (c) 2016 ninjaimg.com

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
