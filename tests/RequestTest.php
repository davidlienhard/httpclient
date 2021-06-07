<?php declare(strict_types=1);

declare(strict_types=1);

namespace DavidLienhard\HttpClient\Tests;

use DavidLienhard\HttpClient\Request;
use DavidLienhard\HttpClient\RequestInterface;
use PHPUnit\Framework\TestCase;

class RequestTestCase extends TestCase
{
    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanBeCreated(): void
    {
        $request = new Request;

        $this->assertInstanceOf(Request::class, $request);
        $this->assertInstanceOf(RequestInterface::class, $request);
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanGetDefaultOptions(): void
    {
        $request = new Request;

        $defaultOptions = [
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_RETURNTRANSFER => true
        ];

        $this->assertEquals($defaultOptions, $request->getOptions());
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetVerifySslPeerToBool(): void
    {
        $request = new Request;

        $request->setVerifySslPeer(true);
        $this->assertEquals(true, $request->getVerifySslPeer());
        $this->assertEquals(true, $request->getOptions()[CURLOPT_SSL_VERIFYPEER]);

        $request->setVerifySslPeer(false);
        $this->assertEquals(false, $request->getVerifySslPeer());
        $this->assertEquals(false, $request->getOptions()[CURLOPT_SSL_VERIFYPEER]);
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetTimeoutToNull(): void
    {
        $request = new Request;

        $request->setTimeout(null);
        $this->assertEquals(null, $request->getTimeout());
        $this->assertArrayNotHasKey(CURLOPT_TIMEOUT, $request->getOptions());
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetTimeoutToInt(): void
    {
        $request = new Request;

        for ($i = 0; $i < 10; $i++) {
            $timeout = rand(1, 1000);
            $request->setTimeout($timeout);
            $this->assertEquals($timeout, $request->getTimeout());
            $this->assertEquals($timeout, $request->getOptions()[CURLOPT_TIMEOUT]);
        }
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetConnectTimeoutToNull(): void
    {
        $request = new Request;

        $request->setConnectTimeout(null);
        $this->assertEquals(null, $request->getConnectTimeout());
        $this->assertArrayNotHasKey(CURLOPT_CONNECTTIMEOUT, $request->getOptions());
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetConnectTimeoutToInt(): void
    {
        $request = new Request;

        for ($i = 0; $i < 10; $i++) {
            $timeout = rand(1, 1000);
            $request->setConnectTimeout($timeout);
            $this->assertEquals($timeout, $request->getConnectTimeout());
            $this->assertEquals($timeout, $request->getOptions()[CURLOPT_CONNECTTIMEOUT]);
        }
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetWriteFunctionToNull(): void
    {
        $request = new Request;

        $request->setWriteFunction(null);

        $options = $request->getOptions();
        $this->assertEquals(null, $request->getWriteFunction());
        $this->assertArrayNotHasKey(CURLOPT_WRITEFUNCTION, $options);
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetWriteFunctionToClosure(): void
    {
        $request = new Request;

        $closure = function () : void {
        };

        $request->setWriteFunction($closure);

        $options = $request->getOptions();
        $this->assertEquals($closure, $request->getWriteFunction());
        $this->assertEquals($closure, $options[CURLOPT_WRITEFUNCTION]);
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetOutfileToNull(): void
    {
        $request = new Request;

        $request->setOutfile(null);

        $options = $request->getOptions();
        $this->assertEquals(null, $request->getOutfile());
        $this->assertArrayNotHasKey(CURLOPT_FILE, $options);
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCannotSetOutfileToString(): void
    {
        $request = new Request;

        $this->expectException(\InvalidArgumentException::class);
        $request->setOutfile("test");
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCannotSetOutfileToResourceOtherThanStream(): void
    {
        $request = new Request;

        $this->expectException(\InvalidArgumentException::class);
        $request->setOutfile(\curl_init());
    }

    /**
     * @covers DavidLienhard\HttpClient\Request
     * @test
     */
    public function testCanSetOutfileToFilehandle(): void
    {
        $request = new Request;

        $handle = fopen("php://stdout", "r");

        $request->setOutfile($handle);

        $options = $request->getOptions();
        $this->assertEquals($handle, $request->getOutfile());
        $this->assertEquals($handle, $options[CURLOPT_FILE]);

        fclose($handle);
    }
}
