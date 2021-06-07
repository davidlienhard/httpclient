<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Cookie;
use DavidLienhard\HttpClient\CookieInterface;
use PHPUnit\Framework\TestCase;

class CookieTestCase extends TestCase
{
    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCanBeCreated(): void
    {
        $cookie = new Cookie("name", "value");

        $this->assertInstanceOf(Cookie::class, $cookie);
        $this->assertInstanceOf(CookieInterface::class, $cookie);
    }

    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCannotCreateWithoutArguments(): void
    {
        $this->expectException(\ArgumentCountError::class);
        new Cookie;
    }

    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCannotCreateWithoutIntForName(): void
    {
        $this->expectException(\TypeError::class);
        new Cookie(1);
    }

    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCannotCreateWithoutBoolForName(): void
    {
        $this->expectException(\TypeError::class);
        new Cookie(true);
    }

    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCannotCreateWithoutValue(): void
    {
        $this->expectException(\ArgumentCountError::class);
        new Cookie("name");
    }

    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCannotCreateWithoutIntForValue(): void
    {
        $this->expectException(\TypeError::class);
        new Cookie("name", 1);
    }

    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCannotCreateWithoutBoolForValue(): void
    {
        $this->expectException(\TypeError::class);
        new Cookie("name", true);
    }

    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCatGetCookieName(): void
    {
        $cookie = new Cookie("name", "value");

        $this->assertEquals("name", $cookie->getName());
    }

    /**
     * @covers DavidLienhard\HttpClient\Cookie
     * @test
     */
    public function testCatGetCookieValue(): void
    {
        $cookie = new Cookie("name", "value");

        $this->assertEquals("value", $cookie->getValue());
    }
}
