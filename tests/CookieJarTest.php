<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Cookie;
use DavidLienhard\HttpClient\CookieJar;
use DavidLienhard\HttpClient\CookieJarInterface;
use PHPUnit\Framework\TestCase;

class CookieJarTestCase extends TestCase
{
    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanBeCreated(): void
    {
        $jar = new CookieJar;

        $this->assertInstanceOf(CookieJar::class, $jar);
        $this->assertInstanceOf(CookieJarInterface::class, $jar);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCannotBeCreatedWithString(): void
    {
        $this->expectException(\TypeError::class);
        new CookieJar("string");
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCannotBeCreatedWithInt(): void
    {
        $this->expectException(\TypeError::class);
        new CookieJar(1);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCannotBeCreatedWithBool(): void
    {
        $this->expectException(\TypeError::class);
        new CookieJar(true);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanBeCreatedWithCookieAsArgument(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie);

        $this->assertInstanceOf(CookieJar::class, $jar);
        $this->assertInstanceOf(CookieJarInterface::class, $jar);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanBeCreatedWithMultipleCookies(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie, $cookie);

        $this->assertInstanceOf(CookieJar::class, $jar);
        $this->assertInstanceOf(CookieJarInterface::class, $jar);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCannotBeCreatedMixedData(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $this->expectException(\TypeError::class);
        new CookieJar($cookie, $cookie, "test", 1, true);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCannotAddStringAsCookie(): void
    {
        $jar = new CookieJar;
        $this->expectException(\TypeError::class);
        $jar->addCookie("string");
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCannotAddIntAsCookie(): void
    {
        $jar = new CookieJar;
        $this->expectException(\TypeError::class);
        $jar->addCookie(1);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCannotAddBoolAsCookie(): void
    {
        $jar = new CookieJar;
        $this->expectException(\TypeError::class);
        $jar->addCookie(true);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCannotAddArrayAsCookie(): void
    {
        $jar = new CookieJar;
        $this->expectException(\TypeError::class);
        $jar->addCookie([ "string" ]);
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanAddCookie(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar;
        $jar->addCookie($cookie);

        $this->assertEquals(1, $jar->getCount());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanAddMultipleCookies(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar;
        $jar->addCookie($cookie, $cookie, $cookie);

        $this->assertEquals(3, $jar->getCount());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanGetCookiesWithoutAnySet(): void
    {
        $jar = new CookieJar;
        $this->assertEquals([], $jar->getCookies());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanGetCookiesWithSetFromConstruct(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie);
        $this->assertEquals([ $cookie, $cookie, $cookie ], $jar->getCookies());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanGetCookiesWithSetFromAddFunction(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar;
        $jar->addCookie($cookie, $cookie, $cookie);
        $this->assertEquals([ $cookie, $cookie, $cookie ], $jar->getCookies());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanGetCookiesWithSetFromConstructAndAddFunction(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie);
        $jar->addCookie($cookie, $cookie, $cookie);
        $this->assertEquals([ $cookie, $cookie, $cookie, $cookie, $cookie, $cookie ], $jar->getCookies());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanGetCookieCountWithSetFromConstruct(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie);
        $this->assertEquals(3, $jar->getCount());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanGetCookieCountSetFromAddFunction(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar;
        $jar->addCookie($cookie, $cookie, $cookie);
        $this->assertEquals(3, $jar->getCount());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanGetCookieCountSetFromConstructAndAddFunction(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $jar = new CookieJar($cookie, $cookie, $cookie);
        $jar->addCookie($cookie, $cookie, $cookie);
        $this->assertEquals(6, $jar->getCount());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testNoCookiesReturnEmptyString(): void
    {
        $jar = new CookieJar;
        $this->assertEquals("", $jar->getAsString());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
    public function testCanGetAsStringWithSingleCookie(): void
    {
        $cookie = $this->createMock(Cookie::class);
        $cookie->method('getName')->willReturn('name');
        $cookie->method('getValue')->willReturn('value');

        $jar = new CookieJar($cookie);
        $this->assertEquals("name=value;", $jar->getAsString());
    }

    /**
     * @covers DavidLienhard\HttpClient\CookieJar
     * @test
     */
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
