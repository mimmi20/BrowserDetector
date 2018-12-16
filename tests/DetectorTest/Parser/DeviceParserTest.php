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
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\SpecificLoaderFactoryInterface;
use BrowserDetector\Loader\SpecificLoaderInterface;
use BrowserDetector\Parser\DeviceParser;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\Json;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class DeviceParserTest extends TestCase
{
    /**
     * @var \BrowserDetector\Parser\DeviceParser
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        self::markTestIncomplete();
        $logger         = $this->createMock(NullLogger::class);
        $jsonParser     = $this->createMock(JsonInterface::class);
        $companyLoader  = $this->createMock(SpecificLoaderInterface::class);
        $platformParser = $this->createMock(PlatformParserInterface::class);

        /* @var NullLogger $logger */
        /* @var Json $jsonParser */
        /* @var \BrowserDetector\Loader\CompanyLoader $companyLoader */
        /* @var PlatformParserInterface $platformParser */
        $this->object = new DeviceParser($logger, $jsonParser, $companyLoader, $platformParser);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvokeDarwin(): void
    {
        self::markTestIncomplete();
        $useragent      = 'UCBrowserHD/2.4.0.367 CFNetwork/672.1.15 Darwin/14.0.0';
        $expectedResult = [];

        $darwinFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $darwinFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'darwinFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $darwinFactory);

        $mobileFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $mobileFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'mobileFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mobileFactory);

        $tvFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $tvFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'tvFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $tvFactory);

        $desktopFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $desktopFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'desktopFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $desktopFactory);

        $loaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $loaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object($useragent));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvokeMobile(): void
    {
        self::markTestIncomplete();
        $useragent      = 'Mozilla/5.0 (Linux; U; Android 4.3; de-de; GT-I9300 Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30';
        $expectedResult = [];

        $darwinFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $darwinFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'darwinFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $darwinFactory);

        $mobileFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $mobileFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'mobileFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mobileFactory);

        $tvFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $tvFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'tvFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $tvFactory);

        $desktopFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $desktopFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'desktopFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $desktopFactory);

        $loaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $loaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object($useragent));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvokeTv(): void
    {
        self::markTestIncomplete();
        $useragent      = 'Mozilla/5.0 AppleWebKit/537.30 (KHTML, like Gecko) Chromium/25.0.1349.2 HbbTV/1.1.1 (;Metz;MMS;;;) CE-HTML/1.0';
        $expectedResult = [];

        $darwinFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $darwinFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'darwinFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $darwinFactory);

        $mobileFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $mobileFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'mobileFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mobileFactory);

        $tvFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $tvFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'tvFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $tvFactory);

        $desktopFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $desktopFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'desktopFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $desktopFactory);

        $loaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $loaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object($useragent));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvokeDesktop(): void
    {
        self::markTestIncomplete();
        $useragent      = 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:26.0.0b2) Goanna/20150828 Gecko/20100101 AppleWebKit/601.1.37 (KHTML, like Gecko) Version/9.0 Safari/601.1.37 PaleMoon/26.0.0b2';
        $expectedResult = [];

        $darwinFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $darwinFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'darwinFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $darwinFactory);

        $mobileFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $mobileFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'mobileFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mobileFactory);

        $tvFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $tvFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'tvFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $tvFactory);

        $desktopFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $desktopFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'desktopFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $desktopFactory);

        $loaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $loaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object($useragent));
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvokeGeneric(): void
    {
        self::markTestIncomplete();
        $useragent      = 'this is a fake ua to trigger the fallback';
        $expectedResult = [];

        $darwinFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $darwinFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'darwinFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $darwinFactory);

        $mobileFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $mobileFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'mobileFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $mobileFactory);

        $tvFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $tvFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'tvFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $tvFactory);

        $desktopFactory = $this->getMockBuilder(DeviceParserInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $desktopFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $property = new \ReflectionProperty($this->object, 'desktopFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $desktopFactory);

        $loader = $this->getMockBuilder(SpecificLoaderInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $loader
            ->expects(self::once())
            ->method('__invoke')
            ->with($useragent)
            ->willReturn($expectedResult);

        $loaderFactory = $this->getMockBuilder(SpecificLoaderFactoryInterface::class)
            ->disableOriginalConstructor()

            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('unknown', 'unknown')
            ->willReturn($loader);

        $property = new \ReflectionProperty($this->object, 'loaderFactory');
        $property->setAccessible(true);
        $property->setValue($this->object, $loaderFactory);

        $object = $this->object;

        self::assertSame($expectedResult, $object($useragent));
    }
}
