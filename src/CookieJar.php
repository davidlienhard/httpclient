<?php declare(strict_types=1);

/**
 * object to contain multiple cookies
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

namespace DavidLienhard\HttpClient;

/**
 * object to contain multiple cookies
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
class CookieJar implements CookieJarInterface
{
    /**
     * list of all cookies in this jar
     * @var     array<CookieInterface>
     */
    private array $cookies = [];

    /**
     * saves cookies into this jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           CookieInterface $cookies    list of cookies to add
     */
    public function __construct(CookieInterface ...$cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * adds new cookies to this jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           CookieInterface $cookies    list of cookies to add
     */
    public function addCookie(CookieInterface ...$cookies) : void
    {
        $this->cookies = array_merge($this->cookies, $cookies);
    }

    /**
     * returns all cookies in this jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getCookies() : array
    {
        return $this->cookies;
    }

    /**
     * returns the number of cookies in this jar
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getCount() : int
    {
        return count($this->cookies);
    }

    /**
     * returns all cookies as a string
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getAsString() : string
    {
        $cookieArray = array_map(
            fn ($cookie) => $cookie->getName()."=".$cookie->getValue().";",
            $this->cookies
        );

        $cookieString = implode("", $cookieArray);

        return $cookieString;
    }
}
