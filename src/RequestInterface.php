<?php declare(strict_types=1);

/**
 * contains the interface for the request configuration object
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

namespace DavidLienhard\HttpClient;

/**
 * interface to set options for the request to send
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
interface RequestInterface
{
    /**
     * sets the verify ssl option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           bool            $verify         whether or not to verify the remote ssl peer
     */
    public function setVerifySslPeer(bool $verify = true) : self;

    /**
     * returns the current value of the verify ssl option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getVerifySslPeer() : bool;


    /**
     * sets a timeout for requests
     * use null for curl default
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           int|null        $timeout        timeout in seconds
     */
    public function setTimeout(int|null $timeout) : self;

    /**
     * returns the current value of the timeout option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getTimeout() : int|null;


    /**
     * sets a timeout for requests
     * use null for curl default
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           int|null        $connectTimeout     timeout in seconds
     */
    public function setConnectTimeout(int|null $connectTimeout) : self;


    /**
     * returns the current value of the connect timeout option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getConnectTimeout() : int|null;


    /**
     * sets a custom callback to handle the output
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           callable|null   $writeFunction  timeout in seconds
     */
    public function setWriteFunction(callable|null $writeFunction) : self;


    /**
     * returns the current value of the write function option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getWriteFunction() : callable|null;


    /**
     * sets a filehandle to write output to
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           mixed           $outfile        timeout in seconds
     */
    public function setOutfile(mixed $outfile) : self;


    /**
     * returns the current value of the outfile option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getOutfile() : mixed;


    /**
     * returns all currently set options as an array to be used by `\curl_setopt_array()`
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getOptions() : array;
}
