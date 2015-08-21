<?php
/**
 * Write a PHP class that implements a custom Stream Wrapper for generating random strings.
 *
 * The only requirements for this challenge is that the random string generator is implemented using a
 * custom Stream Wrapper and works with file_get_contents() and fopen()/fread(). You are open to implement a
 * random string generator with whatever capabilities, level of configurability or URI format that you wish.
 */

require_once 'vendor/autoload.php';

use PHPWeekly\DataSource\ExternalDataSource;
use PHPWeekly\DataSource\HtmlDataSource;
use PHPWeekly\DataSource\LocalDataSource;
use PHPWeekly\Stream\RandomString;

// track execution time
$start = round(microtime(true) * 1000);

/**
 * Custom data sources (optional)
 *
 * Optionally register custom data sources to be used for random
 * string generations in the context stream
 *
 * The default local data source will be used if no custom data sources
 * have been registered
 */
RandomString::addDataSources(
    // external data sources - these will fetch data from remote servers asyncronously
    new ExternalDataSource('https://www.random.org//strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new'),
    new ExternalDataSource('https://www.random.org//strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new'),
    new ExternalDataSource('https://www.random.org//strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new'),
    new ExternalDataSource('https://www.random.org//strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new'),
    new ExternalDataSource('https://www.random.org//strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new'),
    new HtmlDataSource('https://en.wikipedia.org/wiki/Cat'),
    // internal data source - [A-Za-z0-9]
    new LocalDataSource()
);

// register stream context
stream_register_wrapper('random', RandomString::class);

$randomString = file_get_contents("random://100");

echo $randomString . PHP_EOL; // outputs 100 random characters

$randomPointer = fopen("random://100", 'r');

echo fread($randomPointer, 50) . PHP_EOL; // outputs 50 random characters
echo fread($randomPointer, 50) . PHP_EOL; // outputs 50 random characters
echo fread($randomPointer, 1) . PHP_EOL; // outputs empty string because max random characters of 100 was exceeded

echo sprintf('Total runtime: %s ms', round(microtime(true) * 1000) - $start) . PHP_EOL; // output execution time (milliseconds)
