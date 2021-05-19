<?php
/**
 * contains curl abstraction class
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

declare(strict_types=1);

namespace DavidLienhard\HttpClient;

use DavidLienhard\HttpClient\Exceptions\Curl as CurlException;

/**
 * curl abstraction class to improve testabilite of http class
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
class Curl
{
    /** curl handle */
    private \CurlHandle $ch;

    /**
     * initializes the curl handle
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string|null     $url            url to send the request to
     */
    public function init(string|null $url = null) : void
    {
        $ch = \curl_init($url);

        if ($ch === false) {
            throw new CurlException("unable to initialize curl");
        }

        $this->ch = $ch;
    }

    /**
     * sets options from an array
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           array           $options        options to set
     */
    public function setoptArray(array $options) : bool
    {
        return \curl_setopt_array($this->ch, $options);
    }

    /**
     * returns the last error message
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function error() : string
    {
        return \curl_error($this->ch);
    }

    /**
     * returns the last error number
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function errno() : int
    {
        return \curl_errno($this->ch);
    }

    /**
     * closes the current connection
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function close() : void
    {
        \curl_close($this->ch);
    }

    /**
     * gets info from curl
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           int|null        $opt            option to get
     */
    public function getinfo(int|null $opt = null) : mixed
    {
        return \curl_getinfo($this->ch, $opt);
    }

    /**
     * sends the request
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function exec() : mixed
    {
        return \curl_exec($this->ch);
    }
}
