<?php
/**
 * Created by IntelliJ IDEA.
 * User: epfremme
 * Date: 8/17/15
 * Time: 10:26 PM
 */

namespace PHPWeekly\DataSource;

interface DataSourceInterface
{
    /**
     * Return static data source content
     *
     * @return string
     */
    public function getContent();
}
