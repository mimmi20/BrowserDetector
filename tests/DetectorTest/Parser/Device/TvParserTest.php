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
namespace BrowserDetectorTest\Parser\Device;

use BrowserDetector\Loader\SpecificLoaderFactoryInterface;
use BrowserDetector\Loader\SpecificLoaderInterface;
use BrowserDetector\Parser\Device\TvParser;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\Json;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class TvParserTest extends TestCase
{
    /**
     * @var \BrowserDetector\Parser\Device\TvParser
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $logger         = $this->createMock(NullLogger::class);
        $jsonParser     = $this->createMock(JsonInterface::class);
        $platformParser = $this->createMock(PlatformParserInterface::class);

        /* @var NullLogger $logger */
        /* @var Json $jsonParser */
        /* @var PlatformParserInterface $platformParser */
        $this->object = new TvParser($logger, $jsonParser, $platformParser);
    }

    /**
     * @dataProvider providerUseragents
     *
     * @param string $useragent
     * @param string $expectedCompany
     * @param array  $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvoke(string $useragent, string $expectedCompany, array $expectedResult): void
    {
        self::markTestIncomplete();
        $mockLoader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($expectedCompany, 'tv')
            ->willReturn($mockLoader);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mockLoaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object($useragent));
    }

    /**
     * @return array[]
     */
    public function providerUseragents(): array
    {
        return [
            [
                'Opera/9.80 (Linux armv7l; InettvBrowser/2.2 (00014A;SonyDTV140;0001;0001) KD49X8505B; CC/DEU) Presto/2.12.407 Version/12.50',
                'sony',
                [],
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V401; en) Presto/2.10.250 Version/11.60',
                'thomson',
                [],
            ],
            [
                'this is a fake ua to trigger the fallback',
                'unknown',
                [],
            ],
        ];
    }
}