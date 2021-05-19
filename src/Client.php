<?php
/**
 * contains the http client class
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

declare(strict_types=1);

namespace DavidLienhard\HttpClient;

use DavidLienhard\HttpClient\Exceptions\NoResponse as NoResponseException;
use DavidLienhard\HttpClient\Exceptions\Setup as SetupException;

/**
 * class to send http requests to remote servers
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
class Client implements ClientInterface
{
    /** curl handle to use for the connection */
    private Curl $curl;

    /** configuration of the request */
    private RequestInterface $request;

    /** cookiejar to use */
    private CookieJarInterface $cookieJar;

    /**
     * sets the dependencies
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           RequestInterface|null   $request    request object to use
     * @param           CookieJarInterface|null $cookieJar  cookie jar object to use
     */
    public function __construct(
        RequestInterface|null $request = null,
        CookieJarInterface|null $cookieJar = null,
        Curl $curl = null,
    ) {
        if ($request === null) {
            $request = new Request;
        }
        $this->request = $request;

        if ($cookieJar === null) {
            $cookieJar = new CookieJar;
        }
        $this->cookieJar = $cookieJar;

        if ($curl === null) {
            $curl = new Curl;
        }
        $this->curl = $curl;

        $this->curl->init();
    }

    /**
     * sends a get request to the url and parses the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string                  $url        url to send the request to. may also have query parameters
     * @param           array                   $data       data to send. can also be given as query parameters in url
     * @param           array                   $headers    additional headers to send to the remote server
     * @param           RequestInterface|null   $request    request object to use for this request only
     * @return          ResponseInterface                   response object containing data returned from the server
     */
    public function get(string $url, array $data = [], array $headers = [], RequestInterface|null $request = null) : ResponseInterface
    {
        $url = Helpers::parseUrl($url, $data);

        $options = [ CURLOPT_URL => $url ];

        return $this->sendRequest($headers, $options, $request);
    }

    /**
     * sends a post request to the url and parses the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string                  $url        url to send the request to. may also have query parameters
     * @param           string                  $data       data to send. can also be given as query parameters in url
     * @param           array                   $headers    additional headers to send to the remote server
     * @param           RequestInterface|null   $request    request object to use for this request only
     * @return          ResponseInterface                   response object containing data returned from the server
     */
    public function post(string $url, string $data = "", array $headers = [], RequestInterface|null $request = null) : ResponseInterface
    {
        $options = [
            CURLOPT_URL        => $url,
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $data
        ];

        return $this->sendRequest($headers, $options, $request);
    }


    /**
     * sends a delete request to the url and parses the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string                  $url        url to send the request to. may also have query parameters
     * @param           array                   $data       data to send. can also be given as query parameters in url
     * @param           array                   $headers    additional headers to send to the remote server
     * @param           RequestInterface|null   $request    request object to use for this request only
     * @return          ResponseInterface                   response object containing data returned from the server
     */
    public function delete(string $url, array $data = [], array $headers = [], RequestInterface|null $request = null) : ResponseInterface
    {
        $url = Helpers::parseUrl($url, $data);

        $options = [
            CURLOPT_URL           => $url,
            CURLOPT_CUSTOMREQUEST => "DELETE"
        ];

        return $this->sendRequest($headers, $options, $request);
    }

    /**
     * sends the request and parses the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           array                   $requestHeaders additional headers to send to the remote server
     * @param           array                   $options        curl options to use
     * @param           RequestInterface|null   $request        request object to use for this request only
     * @return          ResponseInterface                       body of the returned data
     */
    private function sendRequest(array $requestHeaders, array $options, RequestInterface|null $request) : ResponseInterface
    {
        $requestToUse = $request ?? $this->request;
        $options = $requestToUse->getOptions() + $options;

        if (count($requestHeaders) > 0) {
            $options[CURLOPT_HTTPHEADER] = $requestHeaders;
        }

        $responseHeaders = [];

        $options[CURLOPT_HEADERFUNCTION] = function (\CurlHandle $ch, string $header) use (&$responseHeaders): int {
            $headerTrimmed = \trim($header);
            if (\strlen($headerTrimmed) > 0) {
                $responseHeaders[] = $headerTrimmed;
            }
            return \strlen($header);
        };

        if ($this->cookieJar->getCount() !== 0) {
            $options[CURLOPT_COOKIE] = $this->cookieJar->getAsString();
        }


        if ($this->curl->setoptArray($options) === false) {
            $error = $this->curl->error();
            $errno = $this->curl->errno();
            $this->curl->close();
            throw new SetupException("could not set curl options: ".$error." (".$errno.")");
        }

        $response = $this->curl->exec();

        $responseHeaders = \implode("\n", $responseHeaders);

        if ($response === false) {
            $error = $this->curl->error();
            $errno = $this->curl->errno();
            $this->curl->close();
            throw new NoResponseException("could not send data to the remote url: ".$error." (".$errno.")");
        }


        $httpCode = $this->curl->getinfo(CURLINFO_RESPONSE_CODE);
        $contentType = $this->curl->getinfo(CURLINFO_CONTENT_TYPE);
        $contentType = \is_string($contentType) ? $contentType : "";
        $info = $this->curl->getinfo();
        $info = $info !== false ? $info : [];

        $responseHeaders = Helpers::parseHeaders($responseHeaders);
        $this->cookieJar = Helpers::parseCookies($this->cookieJar, $responseHeaders);
        $body = $response;

        $response = new Response($httpCode, $contentType, $info, $responseHeaders, $this->cookieJar, $body);

        $this->curl->close();

        return $response;
    }
}
