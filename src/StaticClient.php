<?php
/**
 * Created by IntelliJ IDEA.
 * User: epfremme
 * Date: 8/18/15
 * Time: 12:57 AM
 */

namespace PHPWeekly;

use GuzzleHttp\Client;

class StaticClient
{
    /**
     * @var Client
     */
    protected static $client;

    /**
     * Get Client
     *
     * @return Client
     */
    public static function getClient()
    {
        if (!self::$client) {
            self::$client = new CLient();
        }

        return self::$client;
    }

    /**
     * Set Client
     *
     * @param Client $client
     */
    public static function setClient($client)
    {
        self::$client = $client;
    }
}
