<?php declare(strict_types=1);

/**
 * interface to describe a cookie jar
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

namespace DavidLienhard\HttpClient;

/**
 * interface to describe a cookie jar
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
interface CookieJarInterface
{
    /**
     * saves cookies into this jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           CookieInterface $cookies    list of cookies to add
     */
    public function __construct(CookieInterface ...$cookies);

    /**
     * adds new cookies to this jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           CookieInterface $cookies    list of cookies to add
     */
    public function addCookie(CookieInterface ...$cookies) : void;

    /**
     * returns all cookies in this jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getCookies() : array;

    /**
     * returns the number of cookies in this jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getCount() : int;

    /**
     * returns all cookies as a string
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getAsString() : string;
}
