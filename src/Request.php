<?php
/**
 * contains request configuration object
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

declare(strict_types=1);

namespace DavidLienhard\HttpClient;

/**
 * class to set options for the request to send
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
class Request implements RequestInterface
{

    /** whether or not to verify ssl on the peer */
    private bool $verifySslPeer = true;

    /**
     * timeout to use for requests
     * null = curl default
     */
    private int|null $timeout = null;

    /**
     * timeout to use for connecting
     * null = curl default
     */
    private int|null $connectTimeout = null;

    /** function to handle the output returned from the server */
    private mixed $writeFunction = null;

    /** file handle to use to write output from the server */
    private mixed $outfile = null;


    /**
     * sets the verify ssl option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           bool            $verify         whether or not to verify the remote ssl peer
     */
    public function setVerifySslPeer(bool $verify = true) : self
    {
        $this->verifySslPeer = $verify;
        return $this;
    }

    /**
     * returns the current value of the verify ssl option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getVerifySslPeer() : bool
    {
        return $this->verifySslPeer;
    }


    /**
     * sets a timeout for requests
     * use null for curl default
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           int|null        $timeout        timeout in seconds
     */
    public function setTimeout(int|null $timeout) : self
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * returns the current value of the timeout option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getTimeout() : int|null
    {
        return $this->timeout;
    }


    /**
     * sets a timeout for requests
     * use null for curl default
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           int|null        $connectTimeout     timeout in seconds
     * @uses            self::$connectTimeout
     */
    public function setConnectTimeout(int|null $connectTimeout) : self
    {
        $this->connectTimeout = $connectTimeout;
        return $this;
    }


    /**
     * returns the current value of the connect timeout option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getConnectTimeout() : int|null
    {
        return $this->connectTimeout;
    }


    /**
     * sets a custom callback to handle the output
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           callable|null   $writeFunction  timeout in seconds
     */
    public function setWriteFunction(callable|null $writeFunction) : self
    {
        $this->writeFunction = $writeFunction;
        return $this;
    }


    /**
     * returns the current value of the write function option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getWriteFunction() : mixed
    {
        return $this->writeFunction;
    }


    /**
     * sets a filehandle to write output to
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           mixed           $outfile        timeout in seconds
     */
    public function setOutfile(mixed $outfile) : self
    {
        if ((!\is_resource($outfile) || \get_resource_type($outfile) !== "stream") && $outfile !== null) {
            throw new \InvalidArgumentException("outfile must be of type file-pointer");
        }

        $this->outfile = $outfile;
        return $this;
    }


    /**
     * returns the current value of the outfile option
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getOutfile() : mixed
    {
        return $this->outfile;
    }


    /**
     * returns all currently set options as an array to be used by `\curl_setopt_array()`
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     */
    public function getOptions() : array
    {
        $options = [];

        $options[CURLOPT_SSL_VERIFYPEER] = $this->verifySslPeer;
        $options[CURLOPT_RETURNTRANSFER] = true;

        if ($this->timeout !== null) {
            $options[CURLOPT_TIMEOUT] = $this->timeout;
        }

        if ($this->connectTimeout !== null) {
            $options[CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        }

        if ($this->writeFunction !== null) {
            $options[CURLOPT_RETURNTRANSFER] = true;
        }

        if ($this->writeFunction !== null) {
            $options[CURLOPT_WRITEFUNCTION] = $this->writeFunction;
        }

        if ($this->outfile !== null) {
            $options[CURLOPT_FILE] = $this->outfile;
        }

        return $options;
    }
}
