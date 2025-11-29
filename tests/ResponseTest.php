<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\CookieJar;
use DavidLienhard\HttpClient\CookieJarInterface;
use DavidLienhard\HttpClient\Response;
use DavidLienhard\HttpClient\ResponseInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Response::class)]
class ResponseTest extends TestCase
{
    private static function getDummyResponse() : ResponseInterface
    {
        return new Response(
            200,
            "text/plain",
            [
                "key" => "value"
            ],
            [
                "key" => "value"
            ],
            new CookieJar,
            "body"
        );
    }


    #[Test]
    public function testCanBeCreated(): void
    {
        $response = self::getDummyResponse();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }


    #[Test]
    public function testCanGetHttpCode(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals(200, $response->getHttpCode());
    }


    #[Test]
    public function testCanGetContentType(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals("text/plain", $response->getContentType());
    }


    #[Test]
    public function testCanGetInfo(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals([ "key" => "value" ], $response->getInfo());
    }


    #[Test]
    public function testCanGetResponseHeaders(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals([ "key" => "value" ], $response->getResponseHeaders());
    }


    #[Test]
    public function testCanGetCookieJar(): void
    {
        $response = self::getDummyResponse();

        $this->assertInstanceOf(CookieJarInterface::class, $response->getCookieJar());
    }


    #[Test]
    public function testCanGetBody(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals("body", $response->getBody());
    }
}
