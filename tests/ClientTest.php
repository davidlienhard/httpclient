<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Client;
use DavidLienhard\HttpClient\ClientInterface;
use DavidLienhard\HttpClient\CookieJar;
use DavidLienhard\HttpClient\Curl;
use DavidLienhard\HttpClient\Exceptions\NoResponse as NoResponseException;
use DavidLienhard\HttpClient\Exceptions\Setup as SetupException;
use DavidLienhard\HttpClient\Request;
use DavidLienhard\HttpClient\Response;
use DavidLienhard\HttpClient\ResponseInterface;
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

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanBeCreatedWithCurl(): void
    {
        $curl = $this->createMock(Curl::class);

        $client = new Client(curl: $curl);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(ClientInterface::class, $client);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanSendGetRequest(): void
    {
        $curl = $this->createMock(Curl::class);
        $curl->method("setoptArray")->willReturn(true);
        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn("test-body");

        $client = new Client(curl: $curl);
        $response = $client->get("https://www.google.ch");

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanSendPostRequest(): void
    {
        $curl = $this->createMock(Curl::class);
        $curl->method("setoptArray")->willReturn(true);
        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn("test-body");

        $client = new Client(curl: $curl);
        $response = $client->post("https://www.google.ch");

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanSendDeleteRequest(): void
    {
        $curl = $this->createMock(Curl::class);
        $curl->method("setoptArray")->willReturn(true);
        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn("test-body");

        $client = new Client(curl: $curl);
        $response = $client->delete("https://www.google.ch");

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testGetSetupExceptionIfUnableToSetCurlOptions(): void
    {
        $curl = $this->createMock(Curl::class);
        $curl->method("setoptArray")->willReturn(false);

        $client = new Client(curl: $curl);

        $this->expectException(SetupException::class);
        $client->get("https://www.google.ch");
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testGetNoResponseExceptionIfCurlExecReturnsFalse(): void
    {
        $curl = $this->createMock(Curl::class);
        $curl->method("setoptArray")->willReturn(true);
        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn(false);

        $client = new Client(curl: $curl);

        $this->expectException(NoResponseException::class);
        $client->get("https://www.google.ch");
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testHttpHeaderOptionIsNotSetWithNoHeaders(): void
    {
        $curl = $this->createMock(Curl::class);

        // return true if key is set to value
        $curl->method('setoptArray')
            ->will($this->returnCallback(fn ($options) => !isset($options[CURLOPT_HTTPHEADER])));

        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn(true);

        $client = new Client(curl: $curl);

        $response = $client->get("https://www.google.ch");

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanSetCustomHeaders(): void
    {
        $curl = $this->createMock(Curl::class);

        // return true if key is set to value
        $curl->method('setoptArray')
            ->will($this->returnCallback(fn ($options) => ($options[CURLOPT_HTTPHEADER]['key'] ?? null) === "value"));

        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn(true);

        $client = new Client(curl: $curl);

        $response = $client->get(
            url: "https://www.google.ch",
            headers: [ "key" => "value" ]
        );

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCookieOptionIsNotSetWithNoHeaders(): void
    {
        $curl = $this->createMock(Curl::class);

        // return true if key is set to value
        $curl->method('setoptArray')
            ->will($this->returnCallback(fn ($options) => !isset($options[CURLOPT_COOKIE])));

        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn(true);

        $client = new Client(curl: $curl);

        $response = $client->get("https://www.google.ch");

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanSetCookies(): void
    {
        $cookieJar = $this->createMock(CookieJar::class);
        $cookieJar->method("getCount")->willReturn(1);
        $cookieJar->method("getAsString")->willReturn("key=value;");


        $curl = $this->createMock(Curl::class);

        // return true if key is set to value
        $curl->method('setoptArray')
            ->will($this->returnCallback(fn ($options) => ($options[CURLOPT_COOKIE] ?? null) === "key=value;"));

        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn(true);

        $client = new Client(cookieJar: $cookieJar, curl: $curl);

        $response = $client->get("https://www.google.ch");

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @covers DavidLienhard\HttpClient\Client
     * @test
     */
    public function testCanSetRequestOnGetFunction(): void
    {
        $request = $this->createMock(Request::class);
        $request->method("getOptions")->willReturn([ CURLOPT_SSL_VERIFYPEER => false ]);
        $curl = $this->createMock(Curl::class);

        // return true if key is set to value
        $curl->method('setoptArray')
            ->will($this->returnCallback(fn ($options) => ($options[CURLOPT_SSL_VERIFYPEER] ?? null) === false));

        $curl->method("getinfo")->will($this->returnValueMap(
            [
                [ CURLINFO_RESPONSE_CODE, 200 ],
                [ CURLINFO_CONTENT_TYPE, "text/plain" ],
                [ null, [] ]
            ]
        ));
        $curl->method("exec")->willReturn(true);

        $client = new Client(curl: $curl);

        $response = $client->get("https://www.google.ch", request: $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
