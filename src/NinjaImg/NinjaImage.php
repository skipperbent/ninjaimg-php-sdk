<?php
namespace NinjaImg;

class NinjaImage {

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

    public function size($width, $height) {
        return $this->width($width)->height($height);
    }

    public function width($width) {
        return $this->addParam('w', $width);
    }

    public function height($height) {
        return $this->addParam('h', $height);
    }

    public function fit($fit) {
        if(!in_array($fit, self::$fits)) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . join(', ', self::$fits));
        }

        return $this->addParam('fit', $fit);
    }

    public function text($text) {
        return $this->addParam('txt', $text);
    }

    public function textFont($font) {
        return $this->addParam('txtfont', $font);
    }

    public function textColor($hexColor) {
        return $this->addParam('txtclr', $hexColor);
    }

    public function textSize($size) {
        return $this->addParam('txtsize', $size);
    }

    public function textPadding($padding) {
        return $this->addParam('txtpad', $padding);
    }

    public function textFit($fit) {
        if(!in_array($fit, self::$textFits)) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . join(', ', self::$textFits));
        }

        return $this->addParam('txtfit', $fit);
    }

    public function textAlign($align) {
        return $this->addParam('txtalign', $align);
    }

    public function watermark($url) {
        return $this->addParam('mark', $url);
    }

    public function watermarkAlign($align) {
        return $this->addParam('markalign', $align);
    }

    public function watermarkAlpha($opacity) {
        return $this->addParam('markalpha', $opacity);
    }

    public function watermarkFit($fit) {
        if(!in_array($fit, self::$fits)) {
            throw new NinjaException('Invalid value for fit. Valid values are: ' . join(', ', self::$fits));
        }

        return $this->addParam('markfit', $fit);
    }

    public function watermarkWidth($width) {
        return $this->addParam('markw', $width);
    }

    public function watermarkHeight($height) {
        return $this->addParam('markh', $height);
    }

    public function watermarkScale($scale) {
        return $this->addParam('markscale', $scale);
    }

    public function watermarkX($x) {
        return $this->addParam('markx', $x);
    }

    public function watermarkY($y) {
        return $this->addParam('marky', $y);
    }

    public function watermarkPadding($padding) {
        return $this->addParam('markpad', $padding);
    }

    public function quality($quality) {
        return $this->addParam('q', $quality);
    }

    public function gamma($gamma) {
        return $this->addParam('gam', $gamma);
    }

    public function contrast($contrast) {
        return $this->addParam('con', $contrast);
    }

    public function brightness($brightness) {
        return $this->addParam('bri', $brightness);
    }

    public function format($format) {
        if(!in_array($format, self::$formats)) {
            throw new NinjaException('Invalid value for format. Valid values are: ' . join(', ', self::$formats));
        }

        return $this->addParam('fm', $format);
    }

    public function rotation($rotation) {
        return $this->addParam('rot', $rotation);
    }

    public function orientation($orientation) {
        return $this->addParam('or', $orientation);
    }

    public function flip($flip) {
        return $this->addParam('fli', $flip);
    }

    public function blur($amount) {
        return $this->addParam('blur', $amount);
    }

    public function getUrl() {
        $url = parse_url($this->url);
        return '//' . $url['host'] . $url['path'] . (count($this->data)) ? '?' . http_build_query($this->data) : '';
    }

    public function addParam($name, $value) {
        $this->data[$name] = $value;
        return $this;
    }

}