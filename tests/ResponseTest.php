<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\CookieJar;
use DavidLienhard\HttpClient\CookieJarInterface;
use DavidLienhard\HttpClient\Response;
use DavidLienhard\HttpClient\ResponseInterface;
use PHPUnit\Framework\TestCase;

class ResponseTestCase extends TestCase
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


    /**
     * @covers DavidLienhard\HttpClient\Response
     * @test
     */
    public function testCanBeCreated(): void
    {
        $response = self::getDummyResponse();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }


    /**
     * @covers DavidLienhard\HttpClient\Response
     * @test
     */
    public function testCanGetHttpCode(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals(200, $response->getHttpCode());
    }


    /**
     * @covers DavidLienhard\HttpClient\Response
     * @test
     */
    public function testCanGetContentType(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals("text/plain", $response->getContentType());
    }


    /**
     * @covers DavidLienhard\HttpClient\Response
     * @test
     */
    public function testCanGetInfo(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals([ "key" => "value" ], $response->getInfo());
    }


    /**
     * @covers DavidLienhard\HttpClient\Response
     * @test
     */
    public function testCanGetResponseHeaders(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals([ "key" => "value" ], $response->getResponseHeaders());
    }


    /**
     * @covers DavidLienhard\HttpClient\Response
     * @test
     */
    public function testCanGetCookieJar(): void
    {
        $response = self::getDummyResponse();

        $this->assertInstanceOf(CookieJarInterface::class, $response->getCookieJar());
    }


    /**
     * @covers DavidLienhard\HttpClient\Response
     * @test
     */
    public function testCanGetBody(): void
    {
        $response = self::getDummyResponse();

        $this->assertEquals("body", $response->getBody());
    }
}
