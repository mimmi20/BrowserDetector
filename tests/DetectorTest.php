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
use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UaResult\Result\Result;
use UaResult\Result\ResultFactory;
use BrowserDetector\Helper\Constants;
use BrowserDetector\Helper\GenericRequest;
use Psr\Cache\CacheItemPoolInterface;

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
    public function testGetBrowserFromUa($userAgent, Result $expectedResult)
    {
        /** @var \UaResult\Result\Result $result */
        $result = $this->object->getBrowser($userAgent);

        self::assertInstanceOf('\UaResult\Result\Result', $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string                  $userAgent
     * @param \UaResult\Result\Result $expectedResult
     */
    public function testGetBrowserFromArray($userAgent, Result $expectedResult)
    {
        /** @var \UaResult\Result\Result $result */
        $result = $this->object->getBrowser([Constants::HEADER_HTTP_USERAGENT => $userAgent]);

        self::assertInstanceOf('\UaResult\Result\Result', $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string                  $userAgent
     * @param \UaResult\Result\Result $expectedResult
     */
    public function testGetBrowserFromPsr7Message($userAgent, Result $expectedResult)
    {
        $message = $this->createMock('\Psr\Http\Message\MessageInterface');
        $message
            ->expects(self::once())
            ->method('getHeaders')
            ->willReturn([Constants::HEADER_HTTP_USERAGENT => [$userAgent]]);

        /** @var \UaResult\Result\Result $result */
        $result = $this->object->getBrowser($message);

        self::assertInstanceOf('\UaResult\Result\Result', $result);

        self::assertEquals($expectedResult, $result);
    }

    public function testGetBrowserFromInvalid()
    {
        $this->expectException('\UnexpectedValueException');
        $this->expectExceptionMessage('the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface');

        $this->object->getBrowser(new \stdClass());
    }

    /**
     * @return array[]
     */
    public function providerGetBrowser(): array
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
    private static function getCache(): CacheItemPoolInterface
    {
        if (null !== static::$cache) {
            return static::$cache;
        }

        static::$cache = new FilesystemAdapter('', 0, __DIR__ . '/../cache/');

        return static::$cache;
    }

    /**
     * @return \Monolog\Logger
     */
    private static function getLogger(): LoggerInterface
    {
        if (null !== static::$logger) {
            return static::$logger;
        }

        static::$logger = new NullLogger();

        return static::$logger;
    }
}
