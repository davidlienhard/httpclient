<?php declare(strict_types=1);

/**
 * object to contain cookie-data
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

namespace DavidLienhard\HttpClient;

/**
 * contains data of a cookie
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
class Cookie implements CookieInterface
{
    /**
     * saves cookie-data
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string          $name       name of the cookie
     * @param           string          $value      value/payload of the cookie
     */
    public function __construct(private string $name, private string $value)
    {
    }

    /**
     * returns the name of the cookie
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * returns the value/payload of the cookie
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getValue() : string
    {
        return $this->value;
    }
}
