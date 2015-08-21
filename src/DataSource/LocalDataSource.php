<?php
/**
 * Created by IntelliJ IDEA.
 * User: epfremme
 * Date: 8/17/15
 * Time: 10:29 PM
 */

namespace PHPWeekly\DataSource;


class LocalDataSource implements DataSourceInterface
{
    // case sensitive alpha numeric characters
    const CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * @var string
     */
    protected $chars;

    /**
     * Constructor
     *
     * @param string $chars
     */
    public function __construct($chars = self::CHARS)
    {
        $this->chars = $chars;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return str_shuffle($this->chars);
    }
}
