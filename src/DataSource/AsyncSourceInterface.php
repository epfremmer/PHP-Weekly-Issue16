<?php
/**
 * Created by IntelliJ IDEA.
 * User: epfremme
 * Date: 8/17/15
 * Time: 10:26 PM
 */

namespace PHPWeekly\DataSource;

interface AsyncSourceInterface
{
    /**
     * Resolve async request
     *
     * @return $this
     */
    public function resolve();
}
