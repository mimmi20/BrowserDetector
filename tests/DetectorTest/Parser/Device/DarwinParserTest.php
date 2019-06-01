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
use BrowserDetector\Parser\Device\DarwinParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\TestCase;

final class DarwinParserTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $useragent      = 'test-useragent';
        $expectedMode   = 'test-mode';
        $expectedResult = ['test-result'];

        $mockLoader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(static::once())
            ->method('load')
            ->with($expectedMode, $useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(static::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($mockLoader);

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(static::exactly(2))
            ->method('parseFile')
            ->willReturnOnConsecutiveCalls('genericMode', $expectedMode);

        /** @var \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser */
        /** @var \BrowserDetector\Loader\DeviceLoaderFactory $mockLoaderFactory */
        $object = new DarwinParser($fileParser, $mockLoaderFactory);

        static::assertSame($expectedResult, $object->parse($useragent));
    }
}
