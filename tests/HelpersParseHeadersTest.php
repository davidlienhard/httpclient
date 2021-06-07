<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Helpers;
use PHPUnit\Framework\TestCase;

class HelpersParseHeadersTestCase extends TestCase
{
    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseHeaders()
     * @test
     */
    public function testEmptyStringReturnsEmptyArray(): void
    {
        $this->assertEquals([], Helpers::parseHeaders(""));
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseHeaders()
     * @test
     */
    public function testCanParseHttpResponseCode(): void
    {
        $header = "HTTP/1.1 200 OK";
        $expected = [
            0 => "HTTP/1.1 200 OK"
        ];

        $this->assertEquals($expected, Helpers::parseHeaders($header));
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseHeaders()
     * @test
     */
    public function testCanParseSingleHeader(): void
    {
        $header = "Content-type: text/plain";
        $expected = [
            "Content-type" => "text/plain"
        ];

        $this->assertEquals($expected, Helpers::parseHeaders($header));
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseHeaders()
     * @test
     */
    public function testCanParseMultipleHeaders(): void
    {
        $header = "HTTP/1.1 200 OK\n".
            "Date: Tue, 18 May 2021 08:05:37 GMT\n".
            "Server: Apache/2.4.29 (Ubuntu)\n".
            "Content-Length: 324\n".
            "Content-Type: text/html";

        $expected = [
            0                => "HTTP/1.1 200 OK",
            "Date"           => "Tue, 18 May 2021 08:05:37 GMT",
            "Server"         => "Apache/2.4.29 (Ubuntu)",
            "Content-Length" => "324",
            "Content-Type"   => "text/html"
        ];

        $this->assertEquals($expected, Helpers::parseHeaders($header));
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseHeaders()
     * @test
     */
    public function testCanParseLongHeadersOverMultipleLines(): void
    {
        $header = "X-Example: this is a very\n".
            "\tlong header";

        $expected = [
            "X-Example" => "this is a very\r\n\tlong header"
        ];

        $this->assertEquals($expected, Helpers::parseHeaders($header));
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseHeaders()
     * @test
     */
    public function testCanParseHeaderThatExistsTwiceTimes(): void
    {
        $header = "X-Example: this header\n".
            "X-Example: exists twice times";

        $expected = [
            "X-Example" => [
                "this header",
                "exists twice times"
            ]
        ];

        $this->assertEquals($expected, Helpers::parseHeaders($header));
    }


    /**
     * @covers DavidLienhard\HttpClient\Helpers::parseHeaders()
     * @test
     */
    public function testCanParseHeaderThatExistsMultipleTimes(): void
    {
        $header = "X-Example: this header\n".
            "X-Example: exists\n".
            "X-Example: multiple times";

        $expected = [
            "X-Example" => [
                "this header",
                "exists",
                "multiple times"
            ]
        ];

        $this->assertEquals($expected, Helpers::parseHeaders($header));
    }
}
