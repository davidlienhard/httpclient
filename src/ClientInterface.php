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
interface ClientInterface
{
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
    );

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
    public function get(string $url, array $data = [], array $headers = [], RequestInterface|null $request = null) : ResponseInterface;

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
    public function post(string $url, string $data = "", array $headers = [], RequestInterface|null $request = null) : ResponseInterface;


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
    public function delete(string $url, array $data = [], array $headers = [], RequestInterface|null $request = null) : ResponseInterface;
}
