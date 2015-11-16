<?php
namespace NinjaImg;

class ServiceImage {

    const FIT_CLAMP = 'clamp';
    const FIT_CLIP = 'clip';
    const FIT_CROP = 'crop';
    const FIT_SCALE = 'scale';
    const FIT_MAX = 'max';
    const FIT_MIN = 'min';

    const FORMAT_PNG = 'png';
    const FORMAT_JPG = 'jpg';
    const FORMAT_GIF = 'gif';

    const TEXT_FIT_MAX = 'max';

    public static $fits = array(self::FIT_CLAMP, self::FIT_CLIP, self::FIT_CROP, self::FIT_MAX, self::FIT_MIN, self::FIT_SCALE);
    public static $formats = array(self::FORMAT_GIF, self::FORMAT_JPG, self::FORMAT_PNG);
    public static $textFits = array(self::TEXT_FIT_MAX);

    protected $url;
    protected $data;

    public function __construct($url) {
        $this->url = $url;
        $this->data = array();
    }

    public function width($width) {
        $this->data['w'] = $width;
        return $this;
    }

    public function height($height) {
        $this->data['h'] = $height;
        return $this;
    }

    public function fit($fit) {
        if(!in_array($fit, self::$fits)) {
            throw new ServiceException('Invalid value for fit. Valid values are: ' . join(', ', self::$fits));
        }

        $this->data['fit'] = $fit;
        return $this;
    }

    public function text($text) {
        $this->data['txt'] = $text;
        return $this;
    }

    public function textFont($font) {
        $this->data['txtfont'] = $font;
        return $this;
    }

    public function textColor($hexColor) {
        $this->data['txtclr'] = $hexColor;
        return $this;
    }

    public function textSize($size) {
        $this->data['txtsize'] = $size;
        return $this;
    }

    public function textPadding($padding) {
        $this->data['txtpad'] = $padding;
        return $this;
    }

    public function textFit($fit) {
        if(!in_array($fit, self::$textFits)) {
            throw new ServiceException('Invalid value for fit. Valid values are: ' . join(', ', self::$textFits));
        }

        $this->data['txtfit'] = $fit;
        return $this;
    }

    public function textAlign($align) {
        $this->data['txtalign'] = $align;
        return $this;
    }

    public function watermark($url) {
        $this->data['mark'] = $url;
        return $this;
    }

    public function watermarkAlign($align) {
        $this->data['markalign'] = $align;
        return $this;
    }

    public function watermarkAlpha($opacity) {
        $this->data['markalpha'] = $opacity;
        return $this;
    }

    public function watermarkFit($fit) {
        if(!in_array($fit, self::$fits)) {
            throw new ServiceException('Invalid value for fit. Valid values are: ' . join(', ', self::$fits));
        }

        $this->data['markfit'] = $fit;
        return $this;
    }

    public function watermarkWidth($width) {
        $this->data['markw'] = $width;
        return $this;
    }

    public function watermarkHeight($height) {
        $this->data['markh'] = $height;
        return $this;
    }

    public function watermarkScale($scale) {
        $this->data['markscale'] = $scale;
        return $this;
    }

    public function watermarkX($x) {
        $this->data['markx'] = $x;
        return $this;
    }

    public function watermarkY($y) {
        $this->data['marky'] = $y;
        return $this;
    }

    public function watermarkPadding($padding) {
        $this->data['markpad'] = $padding;
        return $this;
    }

    public function quality($quality) {
        $this->data['q'] = $quality;
        return $this;
    }

    public function gamma($gamma) {
        $this->data['gam'] = $gamma;
        return $this;
    }

    public function contrast($contrast) {
        $this->data['con'] = $contrast;
        return $this;
    }

    public function brightness($brightness) {
        $this->data['bri'] = $brightness;
        return $this;
    }

    public function format($format) {
        if(!in_array($format, self::$formats)) {
            throw new ServiceException('Invalid value for format. Valid values are: ' . join(', ', self::$formats));
        }

        $this->data['fm'] = $format;
        return $this;
    }

    public function rotation($rotation) {
        $this->data['rot'] = $rotation;
        return $this;
    }

    public function orientation($orientation) {
        $this->data['or'] = $orientation;
        return $this;
    }

    public function flip($flip) {
        $this->data['fli'] = $flip;
        return $this;
    }

    public function getUrl() {
        $url = rtrim($this->url, '/');

        if(count($this->data)) {
            $url .= '?' . http_build_query($this->data);
        }

        return $url;
    }

}