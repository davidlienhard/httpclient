<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Cookie;
use DavidLienhard\HttpClient\CookieJar;
use DavidLienhard\HttpClient\CookieJarInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CookieJar::class)]
class CookieJarTest extends TestCase
{
    #[Test]
    public function testCanBeCreated(): void
    {
        $jar = new CookieJar;

        $this->assertInstanceOf(CookieJar::class, $jar);
        $this->assertInstanceOf(CookieJarInterface::class, $jar);
    }

    #[Test]
    public function testCannotBeCreatedWithString(): void
    {
        $this->expectException(\TypeError::class);
        new CookieJar("string");
    }

    #[Test]
    public function testCannotBeCreatedWithInt(): void
    {
        $this->expectException(\TypeError::class);
        new CookieJar(1);
    }

    #[Test]
    public function testCannotBeCreatedWithBool(): void
    {
        $this->expectException(\TypeError::class);
        new CookieJar(true);
    }


    #[Test]
    public function testCanBeCreatedWithCookieAsArgument(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie);

        $this->assertInstanceOf(CookieJar::class, $jar);
        $this->assertInstanceOf(CookieJarInterface::class, $jar);
    }


    #[Test]
    public function testCanBeCreatedWithMultipleCookies(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie, $cookie);

        $this->assertInstanceOf(CookieJar::class, $jar);
        $this->assertInstanceOf(CookieJarInterface::class, $jar);
    }


    #[Test]
    public function testCannotBeCreatedMixedData(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $this->expectException(\TypeError::class);
        new CookieJar($cookie, $cookie, "test", 1, true);
    }


    #[Test]
    public function testCannotAddStringAsCookie(): void
    {
        $jar = new CookieJar;
        $this->expectException(\TypeError::class);
        $jar->addCookie("string");
    }


    #[Test]
    public function testCannotAddIntAsCookie(): void
    {
        $jar = new CookieJar;
        $this->expectException(\TypeError::class);
        $jar->addCookie(1);
    }


    #[Test]
    public function testCannotAddBoolAsCookie(): void
    {
        $jar = new CookieJar;
        $this->expectException(\TypeError::class);
        $jar->addCookie(true);
    }


    #[Test]
    public function testCannotAddArrayAsCookie(): void
    {
        $jar = new CookieJar;
        $this->expectException(\TypeError::class);
        $jar->addCookie([ "string" ]);
    }


    #[Test]
    public function testCanAddCookie(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar;
        $jar->addCookie($cookie);

        $this->assertEquals(1, $jar->getCount());
    }


    #[Test]
    public function testCanAddMultipleCookies(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar;
        $jar->addCookie($cookie, $cookie, $cookie);

        $this->assertEquals(3, $jar->getCount());
    }


    #[Test]
    public function testCanGetCookiesWithoutAnySet(): void
    {
        $jar = new CookieJar;
        $this->assertEquals([], $jar->getCookies());
    }


    #[Test]
    public function testCanGetCookiesWithSetFromConstruct(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie);
        $this->assertEquals([ $cookie, $cookie, $cookie ], $jar->getCookies());
    }


    #[Test]
    public function testCanGetCookiesWithSetFromAddFunction(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar;
        $jar->addCookie($cookie, $cookie, $cookie);
        $this->assertEquals([ $cookie, $cookie, $cookie ], $jar->getCookies());
    }


    #[Test]
    public function testCanGetCookiesWithSetFromConstructAndAddFunction(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie);
        $jar->addCookie($cookie, $cookie, $cookie);
        $this->assertEquals([ $cookie, $cookie, $cookie, $cookie, $cookie, $cookie ], $jar->getCookies());
    }


    #[Test]
    public function testCanGetCookieCountWithSetFromConstruct(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie);
        $this->assertEquals(3, $jar->getCount());
    }


    #[Test]
    public function testCanGetCookieCountSetFromAddFunction(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar;
        $jar->addCookie($cookie, $cookie, $cookie);
        $this->assertEquals(3, $jar->getCount());
    }


    #[Test]
    public function testCanGetCookieCountSetFromConstructAndAddFunction(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie);
        $jar->addCookie($cookie, $cookie, $cookie);
        $this->assertEquals(6, $jar->getCount());
    }


    #[Test]
    public function testNoCookiesReturnEmptyString(): void
    {
        $jar = new CookieJar;
        $this->assertEquals("", $jar->getAsString());
    }


    #[Test]
    public function testCanGetAsStringWithSingleCookie(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $cookie->method('getName')->willReturn('name');
        $cookie->method('getValue')->willReturn('value');

        $jar = new CookieJar($cookie);
        $this->assertEquals("name=value;", $jar->getAsString());
    }


    #[Test]
    public function testCanGetAsStringWithMultipleCookies(): void
    {
        $cookie1 = $this->createMock(Cookie::class);
        $cookie1->method('getName')->willReturn('name1');
        $cookie1->method('getValue')->willReturn('value1');

        $cookie2 = $this->createMock(Cookie::class);
        $cookie2->method('getName')->willReturn('name2');
        $cookie2->method('getValue')->willReturn('value2');

        $cookie3 = $this->createMock(Cookie::class);
        $cookie3->method('getName')->willReturn('name3');
        $cookie3->method('getValue')->willReturn('value3');

        $jar = new CookieJar($cookie1, $cookie2, $cookie3);
        $this->assertEquals("name1=value1;name2=value2;name3=value3;", $jar->getAsString());
    }
}
