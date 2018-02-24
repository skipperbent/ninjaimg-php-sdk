<?php

namespace NinjaImg;

class NinjaImage
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

    const TEXT_FIT_MAX = 'max';

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

    public static $textFits = [
        self::TEXT_FIT_MAX,
    ];

    protected $url;
    protected $domain;
    protected $data;

    public function __construct($url, $domain = null)
    {
        $this->url = $url;
        $this->domain = $domain;
        $this->data = [];
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

    /**
     * Fit image
     *
     * @param string $fit
     * @return NinjaImage
     * @throws NinjaException
     */
    public function fit($fit)
    {
        if (in_array($fit, static::$fits, true) === false) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . implode(', ', static::$fits));
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

    public function textPadding($padding)
    {
        return $this->addParam('txtpad', $padding);
    }

    /**
     * Text fit
     * @param string $fit
     * @return NinjaImage
     * @throws NinjaException
     */
    public function textFit($fit)
    {
        if (in_array($fit, static::$textFits, true) === false) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . implode(', ', static::$textFits));
        }

        return $this->addParam('txtfit', $fit);
    }

    public function textAlign($align)
    {
        return $this->addParam('txtalign', $align);
    }

    public function watermark($url)
    {
        return $this->addParam('mark', $url);
    }

    public function watermarkAlign($align)
    {
        return $this->addParam('markalign', $align);
    }

    public function watermarkAlpha($opacity)
    {
        return $this->addParam('markalpha', $opacity);
    }

    /**
     * Watermark fit
     *
     * @param string $fit
     * @return NinjaImage
     * @throws NinjaException
     */
    public function watermarkFit($fit)
    {
        if (in_array($fit, static::$fits, true) === false) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . implode(', ', static::$fits));
        }

        return $this->addParam('markfit', $fit);
    }

    public function watermarkWidth($width)
    {
        return $this->addParam('markw', $width);
    }

    public function watermarkHeight($height)
    {
        return $this->addParam('markh', $height);
    }

    public function watermarkScale($scale)
    {
        return $this->addParam('markscale', $scale);
    }

    public function watermarkX($x)
    {
        return $this->addParam('markx', $x);
    }

    public function watermarkY($y)
    {
        return $this->addParam('marky', $y);
    }

    public function watermarkPadding($padding)
    {
        return $this->addParam('markpad', $padding);
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

    /**
     * Format
     *
     * @param string $format
     * @return NinjaImage
     * @throws NinjaException
     */
    public function format($format)
    {
        if (in_array($format, static::$formats, true) === false) {
            throw new NinjaException('Invalid value for format. Valid values are: ' . implode(', ', static::$formats));
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

    public function getUrl()
    {
        $urlParts = parse_url($this->url);

        $url = '';

        if (isset($url['host']) === true) {
            $url .= '//' . $url['host'];
        } elseif ($this->domain !== null) {
            $url .= '//' . $this->domain;
        }

        $url .= $urlParts['path'];

        if (count($this->data) > 0) {
            $url .= '?' . http_build_query($this->data);
        }

        return $url;
    }

    /**
     * Crop format
     * @param string $format
     * @return NinjaImage
     * @throws NinjaException
     */
    public function crop($format = self::CROP_DEFAULT)
    {
        if (in_array($format, static::$crops, true) === false) {
            throw new NinjaException('Invalid crop type. Valid crop types are: ' . implode(', ', static::$crops));
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

    public function preview()
    {
        return $this->addParam('preview', 'true');
    }

    public function previewSeconds($seconds)
    {
        return $this->addParam('sec', $seconds);
    }

    public function addParam($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function __toString()
    {
        return $this->getUrl();
    }

}