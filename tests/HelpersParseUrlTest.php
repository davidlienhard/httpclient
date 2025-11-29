<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Helpers;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversMethod(Helpers::class, "parseUrl") ]
class HelpersParseUrlTest extends TestCase
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

    #[Test]
    public function testUrlWithoutDataReturnsUrl(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $url = self::generateRandomString();

            $this->assertEquals($url, Helpers::parseUrl($url, []));
        }
    }

    #[Test]
    public function testCanAddSingleParameter(): void
    {
        $url = "https://test.com/";
        $data = [ "param" => "value" ];

        $this->assertEquals("https://test.com/?param=value", Helpers::parseUrl($url, $data));
    }

    #[Test]
    public function testCanAddSingleParameterToUrlWithParameters(): void
    {
        $url = "https://test.com/?has=parameter";
        $data = [ "param" => "value" ];

        $this->assertEquals("https://test.com/?has=parameter&param=value", Helpers::parseUrl($url, $data));
    }

    #[Test]
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
