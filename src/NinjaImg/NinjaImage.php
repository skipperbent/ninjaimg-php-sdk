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

    public static array $fits = [
        self::FIT_CLAMP,
        self::FIT_CLIP,
        self::FIT_CROP,
        self::FIT_MAX,
        self::FIT_MIN,
        self::FIT_SCALE,
    ];

    public static array $crops = [
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

    public static array $formats = [
        self::FORMAT_AUTO,
        self::FORMAT_GIF,
        self::FORMAT_JPG,
        self::FORMAT_PNG,
        self::FORMAT_BMP,
    ];

    public static array $textFits = [
        self::TEXT_FIT_MAX,
    ];

    protected string $url;
    protected ?string $domain = null;
    protected array $data;

    public function __construct($url, $domain = null)
    {
        $this->url = $url;
        $this->domain = $domain;
        $this->data = [];
    }

    public function size(int $width, int $height): self
    {
        return $this->width($width)->height($height);
    }

    public function width(int $width): self
    {
        return $this->addParam('w', $width);
    }

    public function height(int $height): self
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
    public function fit(string $fit): self
    {
        if (in_array($fit, static::$fits, true) === false) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . implode(', ', static::$fits));
        }

        return $this->addParam('fit', $fit);
    }

    public function text(string $text): self
    {
        return $this->addParam('txt', $text);
    }

    public function textFont(string $font): self
    {
        return $this->addParam('txtfont', $font);
    }

    public function textColor(string $hexColor): self
    {
        return $this->addParam('txtclr', $hexColor);
    }

    public function textSize(int $size): self
    {
        return $this->addParam('txtsize', $size);
    }

    public function textPadding(int $padding): self
    {
        return $this->addParam('txtpad', $padding);
    }

    /**
     * Text fit
     * @param string $fit
     * @return NinjaImage
     * @throws NinjaException
     */
    public function textFit(string $fit): self
    {
        if (in_array($fit, static::$textFits, true) === false) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . implode(', ', static::$textFits));
        }

        return $this->addParam('txtfit', $fit);
    }

    public function textAlign(string $align): self
    {
        return $this->addParam('txtalign', $align);
    }

    public function watermark(string $url): self
    {
        return $this->addParam('mark', $url);
    }

    public function watermarkAlign(string $align): self
    {
        return $this->addParam('markalign', $align);
    }

    public function watermarkAlpha(int $opacity): self
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
    public function watermarkFit(string $fit): self
    {
        if (in_array($fit, static::$fits, true) === false) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . implode(', ', static::$fits));
        }

        return $this->addParam('markfit', $fit);
    }

    public function watermarkWidth(int $width): self
    {
        return $this->addParam('markw', $width);
    }

    public function watermarkHeight(int $height): self
    {
        return $this->addParam('markh', $height);
    }

    public function watermarkScale(float $scale): self
    {
        return $this->addParam('markscale', $scale);
    }

    public function watermarkX(float $x): self
    {
        return $this->addParam('markx', $x);
    }

    public function watermarkY(float $y): self
    {
        return $this->addParam('marky', $y);
    }

    public function watermarkPadding(int $padding): self
    {
        return $this->addParam('markpad', $padding);
    }

    public function quality(int $quality): self
    {
        return $this->addParam('q', $quality);
    }

    public function gamma(int $gamma): self
    {
        return $this->addParam('gam', $gamma);
    }

    public function contrast(int $contrast): self
    {
        return $this->addParam('con', $contrast);
    }

    public function brightness(int $brightness): self
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
    public function format(string $format): self
    {
        if (in_array($format, static::$formats, true) === false) {
            throw new NinjaException('Invalid value for format. Valid values are: ' . implode(', ', static::$formats));
        }

        return $this->addParam('fm', $format);
    }

    public function rotation(string $rotation): self
    {
        return $this->addParam('rot', $rotation);
    }

    public function orientation(string $orientation): self
    {
        return $this->addParam('or', $orientation);
    }

    public function flip(string $flip): self
    {
        return $this->addParam('fli', $flip);
    }

    public function blur(int $amount): self
    {
        return $this->addParam('blur', $amount);
    }

    public function getUrl(): string
    {
        $url = '';
        $urlParts = parse_url($this->url);

        if (isset($urlParts['host']) === true) {
            $url .= '//' . $urlParts['host'];
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
    public function crop(string $format = self::CROP_DEFAULT): self
    {
        if (in_array($format, static::$crops, true) === false) {
            throw new NinjaException('Invalid crop type. Valid crop types are: ' . implode(', ', static::$crops));
        }

        return $this->addParam('crop', $format);
    }

    public function opacity(int $amount): self
    {
        return $this->addParam('opa', $amount);
    }

    public function mask(string $image): self
    {
        return $this->addParam('mask', $image);
    }

    public function backgroundColor(string $color): self
    {
        return $this->addParam('bg', $color);
    }

    public function previewSeconds(int $seconds): self
    {
        return $this->addParam('sec', $seconds);
    }

    public function addParam(string $name, $value): self
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function __toString(): string
    {
        return $this->getUrl();
    }

}