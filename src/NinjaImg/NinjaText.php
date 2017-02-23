<?php
namespace NinjaImg;

class NinjaText
{
    const FIT_CLAMP = 'clamp';
    const FIT_CLIP = 'clip';
    const FIT_CROP = 'crop';
    const FIT_SCALE = 'scale';
    const FIT_MAX = 'max';
    const FIT_MIN = 'min';

    const CROP_DEFAULT = '';
    const CROP_BOTTOM_LEFT = 'bottom,left';
    const CROP_BOTTOM_RIGHT = 'bottom,right';
    const CROP_BOTTOM = 'bottom';
    const CROP_LEFT = 'left';
    const CROP_RIGHT = 'right';
    const CROP_TOP = 'top';
    const CROP_TOP_LEFT = 'top,left';
    const CROP_TOP_RIGHT = 'top,right';

    const FORMAT_AUTO = 'auto';
    const FORMAT_PNG = 'png';
    const FORMAT_JPG = 'jpg';
    const FORMAT_GIF = 'gif';
    const FORMAT_BMP = 'bmp';

    public static $fits = [
        self::FIT_CLAMP,
        self::FIT_CLIP,
        self::FIT_CROP,
        self::FIT_MAX,
        self::FIT_MIN,
        self::FIT_SCALE,
    ];

    public static $crops = [
        self::CROP_DEFAULT,
        self::CROP_BOTTOM,
        self::CROP_BOTTOM_LEFT,
        self::CROP_BOTTOM_RIGHT,
        self::CROP_LEFT,
        self::CROP_RIGHT,
        self::CROP_TOP,
        self::CROP_TOP_LEFT,
        self::CROP_TOP_RIGHT,
    ];

    public static $formats = [
        self::FORMAT_AUTO,
        self::FORMAT_GIF,
        self::FORMAT_JPG,
        self::FORMAT_PNG,
        self::FORMAT_BMP,
    ];

    protected $domain;
    protected $data;

    public function __construct($domain)
    {
        $this->domain = $domain;
        $this->data   = [];
    }

    public function size($width, $height)
    {
        return $this->width($width)->height($height);
    }

    public function width($width)
    {
        return $this->addParam('w', $width);
    }

    public function height($height)
    {
        return $this->addParam('h', $height);
    }

    public function fit($fit)
    {
        if (!in_array($fit, self::$fits)) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . join(', ', static::$fits));
        }

        return $this->addParam('fit', $fit);
    }

    public function text($text)
    {
        return $this->addParam('txt', $text);
    }

    public function textFont($font)
    {
        return $this->addParam('txtfont', $font);
    }

    public function textColor($hexColor)
    {
        return $this->addParam('txtclr', $hexColor);
    }

    public function textSize($size)
    {
        return $this->addParam('txtsize', $size);
    }

    public function quality($quality)
    {
        return $this->addParam('q', $quality);
    }

    public function gamma($gamma)
    {
        return $this->addParam('gam', $gamma);
    }

    public function contrast($contrast)
    {
        return $this->addParam('con', $contrast);
    }

    public function brightness($brightness)
    {
        return $this->addParam('bri', $brightness);
    }

    public function format($format)
    {
        if (in_array($format, static::$formats) === false) {
            throw new NinjaException('Invalid value for format. Valid values are: ' . join(', ', static::$formats));
        }

        return $this->addParam('fm', $format);
    }

    public function rotation($rotation)
    {
        return $this->addParam('rot', $rotation);
    }

    public function orientation($orientation)
    {
        return $this->addParam('or', $orientation);
    }

    public function flip($flip)
    {
        return $this->addParam('fli', $flip);
    }

    public function blur($amount)
    {
        return $this->addParam('blur', $amount);
    }

    public function crop($format = self::CROP_DEFAULT)
    {
        if (in_array($format, static::$crops) === false) {
            throw new NinjaException('Invalid crop type. Valid crop types are: ' . join(', ', static::$crops));
        }

        return $this->addParam('crop', $format);
    }

    public function opacity($amount)
    {
        return $this->addParam('opa', $amount);
    }

    public function mask($image)
    {
        return $this->addParam('mask', $image);
    }

    public function backgroundColor($color)
    {
        return $this->addParam('bg', $color);
    }

    public function addParam($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function getUrl()
    {
        return '//' . $this->domain . '/~text' . ((count($this->data) > 0) ? '?' . http_build_query($this->data) : '');
    }

}