<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Parser\Device\TvParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\TestCase;

class TvParserTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $useragent      = 'test-useragent';
        $expectedMode   = 'test-mode';
        $expectedResult = ['test-result'];
        $genericMode    = 'genericMode';

        $mockLoader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('__invoke')
            ->with($expectedMode, $useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($genericMode)
            ->willReturn($mockLoader);

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::exactly(2))
            ->method('parseFile')
            ->willReturnOnConsecutiveCalls($genericMode, $expectedMode);

        /* @var \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser */
        /* @var \BrowserDetector\Loader\DeviceLoaderFactory $mockLoaderFactory */
        $object = new TvParser($fileParser, $mockLoaderFactory);

        self::assertSame($expectedResult, $object($useragent));
    }
}
