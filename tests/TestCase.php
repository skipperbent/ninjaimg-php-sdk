<?php
namespace NinjaImg\Test;

class TestCase extends \PHPUnit\Framework\TestCase {

    protected $ninjaDomain;
    protected $ninjaApiToken;

    protected function setUp()
    {
        parent::setUp();

        global $ninjaDomain;
        global $ninjaApiToken;

        $this->ninjaDomain = $ninjaDomain;
        $this->ninjaApiToken = $ninjaApiToken;
    }

}