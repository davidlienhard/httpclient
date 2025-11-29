<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\CookieJar;
use DavidLienhard\HttpClient\Helpers;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversMethod(Helpers::class, "parseCookies") ]
class HelpersParseCookiesTest extends TestCase
{
    #[Test]
    public function testEmptyArrayReturnsEmptyCookieJar(): void
    {
        $jar = Helpers::parseCookies(new CookieJar, []);

        $this->assertEquals(0, $jar->getCount());
    }


    #[Test]
    public function testArrayWithNoCookiesReturnsEmptyCookieJar(): void
    {
        $headers = [
            0              => "HTTP/1.1 200 OK",
            "Content-Type" => "text/html"
        ];

        $jar = Helpers::parseCookies(new CookieJar, $headers);

        $this->assertEquals(0, $jar->getCount());
    }


    #[Test]
    public function testArrayWithSingleCookieReturnsSingleCookie(): void
    {
        $headers = [
            0              => "HTTP/1.1 200 OK",
            "Content-Type" => "text/html",
            "Set-Cookie"   => "name=value"
        ];

        $jar = Helpers::parseCookies(new CookieJar, $headers);

        $this->assertEquals(1, $jar->getCount());

        $cookies = $jar->getCookies();
        $firstCookie = $cookies[0];
        $this->assertEquals("name", $firstCookie->getName());
        $this->assertEquals("value", $firstCookie->getValue());
    }


    #[Test]
    public function testArrayWithMultipleCookiesReturnsMultipleCookies(): void
    {
        $headers = [
            0              => "HTTP/1.1 200 OK",
            "Content-Type" => "text/html",
            "Set-Cookie"   => [
                "name1=value1",
                "name2=value2",
                "name3=value3"
            ]
        ];

        $jar = Helpers::parseCookies(new CookieJar, $headers);

        $this->assertEquals(3, $jar->getCount());

        $cookies = $jar->getCookies();

        $this->assertEquals("name1", $cookies[0]->getName());
        $this->assertEquals("value1", $cookies[0]->getValue());

        $this->assertEquals("name2", $cookies[1]->getName());
        $this->assertEquals("value2", $cookies[1]->getValue());

        $this->assertEquals("name3", $cookies[2]->getName());
        $this->assertEquals("value3", $cookies[2]->getValue());
    }
}
