<?php
/**
 * interface for the response from the server
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

declare(strict_types=1);

namespace DavidLienhard\HttpClient;

/**
 * interface for the response from the server
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
interface ResponseInterface
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
        int $httpCode,
        string $contentType,
        array $info,
        array $responseHeaders,
        CookieJarInterface $cookieJar,
        string|bool $body
    );


    /**
     * returns the http code from the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getHttpCode() : int;

    /**
     * returns the content type from the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getContentType() : string;

    /**
     * returns the info from the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getInfo() : array;

    /**
     * returns the cookie-jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getCookieJar() : CookieJarInterface;

    /**
     * returns the http header from the response
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getResponseHeaders() : array;

    /**
     * returns the document body
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getBody() : string|bool;
}
