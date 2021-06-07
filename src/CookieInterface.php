<?php declare(strict_types=1);

/**
 * interface for the cookie object
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

namespace DavidLienhard\HttpClient;

/**
 * interface for the cookie object
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
interface CookieInterface
{
    /**
     * saves cookie-data
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string          $name       name of the cookie
     * @param           string          $value      value/payload of the cookie
     */
    public function __construct(string $name, string $value);

    /**
     * returns the name of the cookie
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getName() : string;

    /**
     * returns the value/payload of the cookie
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getValue() : string;
}
