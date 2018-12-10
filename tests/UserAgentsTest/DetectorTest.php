<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UserAgentsTest;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Detector;
use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Factory\ResultFactory;
use ExceptionalJSON\DecodeErrorException;
use ExceptionalJSON\EncodeErrorException;
use JsonClass\Json;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Simple\NullCache;
use Symfony\Component\Finder\Finder;
use UaResult\Browser\BrowserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;

class DetectorTest extends TestCase
{
    /**
     * @var \BrowserDetector\Detector
     */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws \ReflectionException
     *
     * @return void
     */
    protected function setUp(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $cache = new NullCache();

        /** @var NullLogger $logger */
        $deviceFactory   = new DeviceFactory($logger);
        $platformFactory = new PlatformFactory($logger);
        $browserFactory  = new BrowserFactory($logger);
        $engineFactory   = new EngineFactory($logger);

        $this->object = new Detector($logger, new Cache($cache), $deviceFactory, $platformFactory, $browserFactory, $engineFactory);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param array  $headers
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return void
     */
    public function testGetBrowser(array $headers, Result $expectedResult): void
    {
        $object = $this->object;

        /* @var Result $result */
        $result = $object($headers);

        try {
            $encodedHeaders = (new Json())->encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } catch (EncodeErrorException $e) {
            $encodedHeaders = '< failed to encode headers >';
        }

        static::assertInstanceOf(
            ResultInterface::class,
            $result,
            sprintf(
                'found result is not an instance of "\UaResult\Result\ResultInterface" for headers %s',
                $encodedHeaders
            )
        );

        $foundBrowser = $result->getBrowser();

        static::assertInstanceOf(
            BrowserInterface::class,
            $foundBrowser,
            sprintf(
                'found browser is not an instance of "\UaResult\Browser\BrowserInterface" for headers %s',
                $encodedHeaders
            )
        );

        $foundEngine = $result->getEngine();

        static::assertInstanceOf(
            EngineInterface::class,
            $foundEngine,
            sprintf(
                'found engine is not an instance of "\UaResult\Engine\EngineInterface" for headers %s',
                $encodedHeaders
            )
        );

        $foundPlatform = $result->getOs();

        static::assertInstanceOf(
            OsInterface::class,
            $foundPlatform,
            sprintf(
                'found platform is not an instance of "\UaResult\Os\OsInterface" for headers %s',
                $encodedHeaders
            )
        );

        $foundDevice = $result->getDevice();

        static::assertInstanceOf(
            DeviceInterface::class,
            $foundDevice,
            sprintf(
                'found result is not an instance of "\UaResult\Device\DeviceInterface" for headers %s',
                $encodedHeaders
            )
        );

        self::assertEquals(
            $expectedResult,
            $result,
            sprintf(
                'detection result mismatch for headers %s',
                $encodedHeaders
            )
        );
    }

    /**
     * @throws \Exception
     *
     * @return array[]
     */
    public function providerGetBrowser(): array
    {
        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in('tests/data/');

        $data   = [];
        $logger = new NullLogger();

        foreach ($finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */

            try {
                $tests = (new Json())->decode(
                    $file->getContents(),
                    true
                );
            } catch (DecodeErrorException $e) {
                throw new \Exception(sprintf('file "%s" contains invalid json', $file->getPathname()), 0, $e);
            }

            foreach ($tests as $i => $test) {
                $expectedResult = (new ResultFactory())->fromArray($logger, $test);
                $index          = sprintf('file:%s test:%d', $file->getRelativePathname(), $i);

                $data[$index] = [
                    'headers' => $expectedResult->getHeaders(),
                    'result' => $expectedResult,
                ];
            }
        }

        return $data;
    }
}
