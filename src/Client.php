<?php
/**
 * contains the http client class
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

declare(strict_types=1);

namespace DavidLienhard\HttpClient;

/**
 * class to send http requests to remote servers
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
class Client implements ClientInterface
{
    /** curl handle to use for the connection */
    private \CurlHandle $ch;

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
        CookieJarInterface|null $cookieJar = null
    ) {
        $this->ch = \curl_init();

        if ($request === null) {
            $request = new Request;
        }
        $this->request = $request;

        if ($cookieJar === null) {
            $cookieJar = new CookieJar;
        }
        $this->cookieJar = $cookieJar;
    }

    /**
     * sends a get request to the url and parses the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string          $url            url to send the request to. may also have query parameters
     * @param           array           $data           data to send. can also be given as query parameters in url
     * @param           array           $headers        additional headers to send to the remote server
     * @return          ResponseInterface               response object containing data returned from the server
     */
    public function get(string $url, array $data = [], array $headers = []) : ResponseInterface
    {
        $url = Helpers::parseUrl($url, $data);

        $options = [ CURLOPT_URL => $url ];

        return $this->sendRequest($headers, $options);
    }

    /**
     * sends a post request to the url and parses the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string          $url            url to send the request to. may also have query parameters
     * @param           string          $data           data to send. can also be given as query parameters in url
     * @param           array           $headers        additional headers to send to the remote server
     * @return          ResponseInterface               response object containing data returned from the server
     */
    public function post(string $url, string $data = "", array $headers = []) : ResponseInterface
    {
        $options = [
            CURLOPT_URL        => $url,
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $data
        ];

        return $this->sendRequest($headers, $options);
    }


    /**
     * sends a delete request to the url and parses the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string          $url            url to send the request to. may also have query parameters
     * @param           array           $data           data to send. can also be given as query parameters in url
     * @param           array           $headers        additional headers to send to the remote server
     * @return          ResponseInterface               response object containing data returned from the server
     */
    public function delete(string $url, array $data = [], array $headers = []) : ResponseInterface
    {
        $url = Helpers::parseUrl($url, $data);

        $options = [
            CURLOPT_URL           => $url,
            CURLOPT_CUSTOMREQUEST => "DELETE"
        ];

        return $this->sendRequest($headers, $options);
    }

    /**
     * sends the request and parses the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           array           $requestHeaders additional headers to send to the remote server
     * @param           array           $options        curl options to use
     * @return          ResponseInterface               body of the returned data
     */
    private function sendRequest(array $requestHeaders, array $options) : ResponseInterface
    {
        $options = $this->request->getOptions() + $options;

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


        if (\curl_setopt_array($this->ch, $options) === false) {
            $error = \curl_error($this->ch);
            $errno = \curl_errno($this->ch);
            \curl_close($this->ch);
            throw new \Exception("could not set curl options: ".$error." (".$errno.")");
        }

        $response = \curl_exec($this->ch);

        $responseHeaders = \implode("\n", $responseHeaders);

        if ($response === false) {
            $error = \curl_error($this->ch);
            $errno = \curl_errno($this->ch);
            \curl_close($this->ch);
            throw new \Exception("could not send data to the remote url: ".$error." (".$errno.")");
        }


        $httpCode = \curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);
        $contentType = \curl_getinfo($this->ch, CURLINFO_CONTENT_TYPE);
        $contentType = \is_string($contentType) ? $contentType : "";
        $info = \curl_getinfo($this->ch);
        $info = $info !== false ? $info : [];

        $responseHeaders = Helpers::parseHeaders($responseHeaders);
        $this->cookieJar = Helpers::parseCookies($this->cookieJar, $responseHeaders);
        $body = $response;

        $response = new Response($httpCode, $contentType, $info, $responseHeaders, $this->cookieJar, $body);

        \curl_close($this->ch);

        return $response;
    }
}
