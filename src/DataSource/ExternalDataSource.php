<?php
/**
 * Created by IntelliJ IDEA.
 * User: epfremme
 * Date: 8/17/15
 * Time: 10:29 PM
 */

namespace PHPWeekly\DataSource;
use GuzzleHttp\Psr7\Uri;
use PHPWeekly\DataSource\Traits\AsyncableTrait;
use Psr\Http\Message\ResponseInterface;

class ExternalDataSource implements DataSourceInterface, AsyncSourceInterface
{
    use AsyncableTrait;

    /**
     * @var Uri
     */
    protected $uri;

    /**
     * @var string
     */
    protected $content;

    /**
     * Constructor
     *
     * @param $uri
     */
    public function __construct($uri)
    {
        $this->uri = new Uri($uri);

        $this->makeRequest($this->uri)
            ->then(function(ResponseInterface $response) {
                $this->content = $response->getBody();
            });
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        if (!$this->content) {
            $this->resolve();
        }

        return trim($this->content);
    }
}
