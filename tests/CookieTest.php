<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Cookie;
use DavidLienhard\HttpClient\CookieInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Cookie::class)]
class CookieTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $cookie = new Cookie("name", "value");

        $this->assertInstanceOf(Cookie::class, $cookie);
        $this->assertInstanceOf(CookieInterface::class, $cookie);
    }


    #[Test]
    public function testCannotCreateWithoutArguments(): void
    {
        $this->expectException(\ArgumentCountError::class);
        new Cookie;
    }


    #[Test]
    public function testCannotCreateWithoutIntForName(): void
    {
        $this->expectException(\TypeError::class);
        new Cookie(1);
    }


    #[Test]
    public function testCannotCreateWithoutBoolForName(): void
    {
        $this->expectException(\TypeError::class);
        new Cookie(true);
    }


    #[Test]
    public function testCannotCreateWithoutValue(): void
    {
        $this->expectException(\ArgumentCountError::class);
        new Cookie("name");
    }


    #[Test]
    public function testCannotCreateWithoutIntForValue(): void
    {
        $this->expectException(\TypeError::class);
        new Cookie("name", 1);
    }


    #[Test]
    public function testCannotCreateWithoutBoolForValue(): void
    {
        $this->expectException(\TypeError::class);
        new Cookie("name", true);
    }


    #[Test]
    public function testCatGetCookieName(): void
    {
        $cookie = new Cookie("name", "value");

        $this->assertEquals("name", $cookie->getName());
    }


    #[Test]
    public function testCatGetCookieValue(): void
    {
        $cookie = new Cookie("name", "value");

        $this->assertEquals("value", $cookie->getValue());
    }
}
