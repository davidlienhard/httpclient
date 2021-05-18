<?php

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Client;
use DavidLienhard\HttpClient\ClientInterface;
use DavidLienhard\HttpClient\CookieJar;
use DavidLienhard\HttpClient\Request;
use PHPUnit\Framework\TestCase;

class ClientTestCase extends TestCase
{
    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanBeCreated(): void
    {
        $client = new Client;

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(ClientInterface::class, $client);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanBeCreatedWithRequest(): void
    {
        $request = $this->createMock(Request::class);
        $client = new Client($request);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(ClientInterface::class, $client);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanBeCreatedWithRequestAndCookieJar(): void
    {
        $request = $this->createMock(Request::class);
        $jar = $this->createMock(CookieJar::class);

        $client = new Client($request, $jar);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(ClientInterface::class, $client);
    }
}
