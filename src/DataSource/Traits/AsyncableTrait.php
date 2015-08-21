<?php
/**
 * Created by IntelliJ IDEA.
 * User: epfremme
 * Date: 8/18/15
 * Time: 12:16 AM
 */

namespace PHPWeekly\DataSource\Traits;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Uri;
use PHPWeekly\StaticClient;

trait AsyncableTrait
{
    /**
     * @var Promise
     */
    protected $promise;

    /**
     * {@inheritdoc}
     */
    public function makeRequest(Uri $uri)
    {
        return $this->promise = StaticClient::getClient()->getAsync($uri);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve()
    {
        $this->promise->wait();
    }
}
