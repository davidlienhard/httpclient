<?php declare(strict_types=1);

/**
 * contains helpers methods
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */

namespace DavidLienhard\HttpClient;

/**
 * contains helpers methods
 *
 * @author          David Lienhard <github@lienhard.win>
 * @copyright       David Lienhard
 */
class Helpers
{
    /**
     * puts a valid get url from $url and $data together
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string          $url            url as a string
     * @param           array           $data           additional data
     * @return          string                          the complete url
     */
    public static function parseUrl(string $url, array $data) : string
    {
        \array_walk(
            $data,
            function (string &$value, string $key): void {
                $value = \urlencode($key)."=".\urldecode($value);
            }
        );

        $hasQueryString = \parse_url($url, PHP_URL_QUERY) !== null;

        $queryString = "";
        if (\count($data) > 0) {
            $queryString = $hasQueryString || \substr($url, -1) === "?"
                ? "&"
                : "?";

            $queryString .= \implode("&", $data);
        }

        return $url.$queryString;
    }


    /**
     * parses the headers from raw string to an array
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           string          $rawHeaders     the raw headers as a string
     * @return          array                           formated headers
     */
    public static function parseHeaders(string $rawHeaders) : array
    {
        if (\trim($rawHeaders) === "") {
            return [];
        }

        $headers = [];
        $key = "";

        foreach (\explode("\n", $rawHeaders) as $i => $h) {
            $h = \explode(":", $h, 2);

            if (isset($h[1])) {
                if (!isset($headers[$h[0]])) {
                    $headers[$h[0]] = trim($h[1]);
                } elseif (is_array($headers[$h[0]])) {
                    $headers[$h[0]] = \array_merge($headers[$h[0]], [ \trim($h[1]) ]);
                } else {
                    $headers[$h[0]] = \array_merge([ $headers[$h[0]] ], [ \trim($h[1]) ]);
                }

                $key = $h[0];
            } else {
                if (\substr($h[0], 0, 1) === "\t") {
                    $headers[$key] .= "\r\n\t".\trim($h[0]);
                } elseif (!$key) {
                    $headers[0] = \trim($h[0]);
                }
            }
        }//end foreach

        return $headers;
    }


    /**
     * parses the given cookies from http header
     *
     * @author          David Lienhard <github@lienhard.win>
     * @copyright       David Lienhard
     * @param           CookieJarInterface  $cookieJar  jar to add the cookies to
     * @param           array               $headers    list of the headers
     */
    public static function parseCookies(CookieJarInterface $cookieJar, array $headers) : CookieJarInterface
    {
        $headers = \array_change_key_case($headers, CASE_LOWER);
        $cookiesToSet = $headers['set-cookie'] ?? [];
        $cookiesToSet = !\is_array($cookiesToSet) ? [ $cookiesToSet ] : $cookiesToSet;

        foreach ($cookiesToSet as $cookie) {
            list($cookie) = \explode("; ", $cookie);
            $cookie = \explode("=", \trim($cookie));
            $cookie = new Cookie($cookie[0], $cookie[1]);
            $cookieJar->addCookie($cookie);
        }

        return $cookieJar;
    }
}
