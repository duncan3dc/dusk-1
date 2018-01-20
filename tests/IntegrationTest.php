<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\SupportsChrome;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    use SupportsChrome;

    private static $afterClassCallbacks = [];

    public static function setUpBeforeClass()
    {
        static::startChromeDriver();
    }

    protected static function afterClass(callable $callback)
    {
        self::$afterClassCallbacks[] = $callback;
    }

    public static function tearDownAfterClass()
    {
        foreach (static::$afterClassCallbacks as $callback) {
            $callback();
        }
    }

    public function getDriver()
    {
        return RemoteWebDriver::create("http://localhost:9515", DesiredCapabilities::chrome());
    }


    public function testCanRun()
    {
        $browser = new Browser($this->getDriver());

        $browser->visit('https://laravel.com/');

        $browser->assertSee('Laravel');
    }
}
