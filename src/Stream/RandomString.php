<?php
/**
 * RandomString.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

namespace PHPWeekly\Stream;

use GuzzleHttp\Psr7\Uri;
use PHPWeekly\DataSource\DataSourceInterface;
use PHPWeekly\DataSource\LocalDataSource;
use Psr\Http\Message\StreamInterface;

/**
 * Class RandomString
 *
 * @package PHPWeekly
 */
class RandomString //implements StreamInterface // - was gonna but just no
{
    /**
     * @var int
     */
    protected $length;

    /**
     * @var \Closure
     */
    protected $iterator;

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var DataSourceInterface[]
     */
    protected static $dataSources = [];

    /**
     * Initialize the stream client and resources
     *
     * @param string $path
     */
    protected function initialize($path)
    {
        $uri = new Uri($path);

        if (!ctype_digit($uri->getHost())) {
            throw new \InvalidArgumentException(sprintf('path "%s" must be of type integer', $path));
        }

        $this->length = (int) $uri->getHost();
    }

    /**
     * Return data sources
     *
     * @return DataSourceInterface[]
     */
    public static function getDataSources()
    {
        if (!self::$dataSources) {
            self::addDataSource(new LocalDataSource());
        }

        return self::$dataSources;
    }

    /**
     * Add data source
     *
     * @param DataSourceInterface $dataSource
     * @return void
     */
    public static function addDataSource(DataSourceInterface $dataSource)
    {
        self::$dataSources[] = $dataSource;
    }

    /**
     * Add data sources
     *
     * @param DataSourceInterface[] ...$dataSources
     * @return void
     */
    public static function addDataSources(...$dataSources)
    {
        array_map(__CLASS__.'::addDataSource', $dataSources);
    }

    /**
     * Reset data sources
     *
     * @return void
     */
    public function resetDataSources()
    {
        self::$dataSources = [];
    }

    /**
     * Resolve all request promises and return response data
     *
     * @return string
     */
    protected function getContent()
    {
        return array_reduce($this->getDataSources(), function($result, DataSourceInterface $dataSource) {
            return str_shuffle($result . $dataSource->getContent());
        });
    }

    /**
     * Return random string generator
     *
     * @param int $length
     * @return \Generator
     */
    protected function getGenerator($length = 0)
    {
        $generator = function($length) {
            if (!$content = $this->getContent()) {
                throw new \Exception('Missing seed content');
            }

            for ($i = 1; $i <= $length; $i++) {
                if ($this->stream_eof()) {
                    return;
                }

                $this->position++;

                yield $content[rand(0, strlen($content)-1)];
            }
        };

        return $generator($length);
    }

    /**
     * {@inheritdoc}
     */
    public function stream_open($path)
    {
        $this->initialize($path);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function stream_read($length)
    {
        $result = '';

        foreach ($this->getGenerator($length) as $char) {
            $result .= $char;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function stream_eof()
    {
        return $this->position >= $this->length;
    }

    /**
     * {@inheritdoc}
     */
    public function stream_stat()
    {
        return [];
    }
}
