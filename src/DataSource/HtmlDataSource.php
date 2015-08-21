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

class HtmlDataSource implements DataSourceInterface, AsyncSourceInterface
{
    use AsyncableTrait;

    /**
     * @var \DOMDocument
     */
    protected $document;

    /**
     * @var string
     */
    protected $content;

    /**
     * {@inheritdoc}
     */
    public function __construct($uri)
    {
        $this->uri = new Uri($uri);
        $this->document = new \DOMDocument();

        $this->makeRequest($this->uri)
            ->then(function(ResponseInterface $response) {
                @$this->document->loadHTML($response->getBody());
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

        return $this->parseContent();
    }

    /**
     * Return a filtered plan text
     * version of the document
     *
     * @return string
     */
    protected function parseContent()
    {
        return preg_replace('/[^A-Za-z0-9]/', '', $this->document->textContent);
    }
}
