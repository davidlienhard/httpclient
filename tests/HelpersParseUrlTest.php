<?php

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Helpers;
use PHPUnit\Framework\TestCase;

class HelpersParseUrlTestCase extends TestCase
{
    private static function generateRandomString(int $length = 50) : string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseUrl()
     * @test
     */
    public function testUrlWithoutDataReturnsUrl(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $url = self::generateRandomString();

            $this->assertEquals($url, Helpers::parseUrl($url, []));
        }
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseUrl()
     * @test
     */
    public function testCanAddSingleParameter(): void
    {
        $url = "https://test.com/";
        $data = [ "param" => "value" ];

        $this->assertEquals("https://test.com/?param=value", Helpers::parseUrl($url, $data));
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseUrl()
     * @test
     */
    public function testCanAddSingleParameterToUrlWithParameters(): void
    {
        $url = "https://test.com/?has=parameter";
        $data = [ "param" => "value" ];

        $this->assertEquals("https://test.com/?has=parameter&param=value", Helpers::parseUrl($url, $data));
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseUrl()
     * @test
     */
    public function testCanAddMultipleParameters(): void
    {
        $url = "https://test.com/";
        $data = [
            "param1" => "value1",
            "param2" => "value2",
            "param3" => "value3"
        ];

        $this->assertEquals(
            "https://test.com/?param1=value1&param2=value2&param3=value3",
            Helpers::parseUrl($url, $data)
        );
    }
}
