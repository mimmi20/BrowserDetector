<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest;

use BrowserDetector\Detector;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Log\NullLogger;
use UaResult\Result\Result;
use UaResult\Result\ResultFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class DetectorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Detector
     */
    private $object = null;

    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    private static $cache = null;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private static $logger = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Detector(static::getCache(), static::getLogger());
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string                  $userAgent
     * @param \UaResult\Result\Result $expectedResult
     */
    public function testGetBrowser($userAgent, Result $expectedResult)
    {
        /** @var \UaResult\Result\Result $result */
        $result = $this->object->getBrowser($userAgent);

        self::assertInstanceOf('\UaResult\Result\Result', $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function providerGetBrowser()
    {
        $data  = [];
        $tests = json_decode(file_get_contents('tests/data/detector.json'));

        foreach ($tests as $key => $test) {
            if (isset($data[$key])) {
                // Test data is duplicated for key
                continue;
            }

            $data[$key] = [
                'ua'     => $test->ua,
                'result' => (new ResultFactory())->fromArray(static::getCache(), static::getLogger(), (array) $test->result),
            ];
        }

        return $data;
    }

    /**
     * @return \Psr\Cache\CacheItemPoolInterface
     */
    private static function getCache()
    {
        if (null !== static::$cache) {
            return static::$cache;
        }

        $adapter       = new Local(__DIR__ . '/../cache/');
        static::$cache = new FilesystemCachePool(new Filesystem($adapter));

        return static::$cache;
    }

    /**
     * @return \Monolog\Logger
     */
    private static function getLogger()
    {
        if (null !== static::$logger) {
            return static::$logger;
        }

        static::$logger = new NullLogger();

        return static::$logger;
    }
}
