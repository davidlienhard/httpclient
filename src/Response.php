<?php
/**
 * contains the response returned from the server
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

declare(strict_types=1);

namespace DavidLienhard\HttpClient;

/**
 * contains the response returned from the server
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
class Response implements ResponseInterface
{
    /**
     * saves all the data into this object
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           int                 $httpCode           returned http-code
     * @param           string              $contentType        content-type of the document
     * @param           array               $info               curl info
     * @param           array               $responseHeaders    headers returned from the server
     * @param           CookieJarInterface  $cookieJar          cookie jar containing all cookies
     * @param           string|bool         $body               body of the document
     */
    public function __construct(
        private int $httpCode,
        private string $contentType,
        private array $info,
        private array $responseHeaders,
        private CookieJarInterface $cookieJar,
        private string|bool $body
    ) {
    }


    /**
     * returns the http code from the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getHttpCode() : int
    {
        return $this->httpCode;
    }

    /**
     * returns the content type from the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getContentType() : string
    {
        return $this->contentType;
    }

    /**
     * returns the info from the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getInfo() : array
    {
        return $this->info;
    }

    /**
     * returns the cookie-jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getCookieJar() : CookieJarInterface
    {
        return $this->cookieJar;
    }

    /**
     * returns the http header from the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getResponseHeaders() : array
    {
        return $this->responseHeaders;
    }

    /**
     * returns the document body
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getBody() : string
    {
        return \is_string($this->body) ? $this->body : "";
    }
}
