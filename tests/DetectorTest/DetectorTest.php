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
namespace BrowserDetectorTest;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Detector;
use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\NotFoundException;
use ExceptionalJSON\DecodeErrorException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use UaRequest\Constants;
use UaRequest\GenericRequestFactory;
use UaResult\Browser\Browser;
use UaResult\Device\Device;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UaResult\Result\Result;
use Zend\Diactoros\ServerRequestFactory;

class DetectorTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUaOld(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->createMock(Device::class);
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        /* @var \UaResult\Result\Result $result */
        $result = $object->getBrowser('testagent');

        self::assertInstanceOf(Result::class, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromGenericRequest(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->createMock(Device::class);
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /* @var Result $result */
        $result = $object($request);

        self::assertInstanceOf(Result::class, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromGenericRequest2(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->createMock(Device::class);
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $mockResult = $this->createMock(Result::class);

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::exactly(2))
            ->method('hasItem')
            ->willReturn(true);
        $cache
            ->expects(self::exactly(2))
            ->method('getItem')
            ->willReturn($mockResult);
        $cache
            ->expects(self::never())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /* @var Result $result */
        $result = $object($request);

        self::assertInstanceOf(Result::class, $result);
        self::assertSame($mockResult, $result);

        /* @var Result $result2 */
        $result2 = $object($message);

        self::assertSame($result, $result2);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromInvalid(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $device = $this->createMock(Device::class);
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::never())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::never())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface');

        $object(new \stdClass());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUa(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->createMock(Device::class);
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        /* @var \UaResult\Result\Result $result */
        $result = $object('testagent');

        self::assertInstanceOf(Result::class, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromArray(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->createMock(Device::class);
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        /* @var Result $result */
        $result = $object([Constants::HEADER_HTTP_USERAGENT => 'testagent']);

        self::assertInstanceOf(Result::class, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromPsr7Message(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        $device = $this->getMockBuilder(Device::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUnknownDevice(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::once())
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

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $os = $this->getMockBuilder(Os::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('test-os');

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertNull($result->getDevice()->getDeviceName());
        self::assertSame('test-os', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUnknownDeviceAndPlatform(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::exactly(2))
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

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new NotFoundException('test')));

        $browser = $this->createMock(Browser::class);
        $engine = $this->createMock(Engine::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, $engine]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertNull($result->getDevice()->getDeviceName());
        self::assertNull($result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngine(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->getMockBuilder(Device::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);
        $engine = $this->getMockBuilder(Engine::class)->getMock();
        $engine->expects(self::once())
            ->method('getName')
            ->willReturn('test-engine');

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($engine));
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('test-engine', $result->getEngine()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngine2(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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
            ->expects(self::once())
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

        $device = $this->getMockBuilder(Device::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->createMock(Os::class);

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::throwException(new InvalidArgumentException('test')));
        $engineFactory
            ->expects(self::never())
            ->method('load');

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIos(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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

        $device = $this->getMockBuilder(Device::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');

        $os = $this->getMockBuilder(Os::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('iOS');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $os = $this->createMock(Os::class);

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engine = $this->getMockBuilder(Engine::class)->getMock();
        $engine->expects(self::once())
            ->method('getName')
            ->willReturn('test-engine');

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($engine));

        $engine2 = $this->getMockBuilder(Engine::class)->getMock();
        $engine2->expects(self::once())
            ->method('getName')
            ->willReturn('webkit-test');
        $engineFactory
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::returnValue($engine2));

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertSame('webkit-test', $result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIosFail(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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
            ->expects(self::once())
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

        $device = $this->getMockBuilder(Device::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(Os::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('iOS');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $os = $this->createMock(Os::class);

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::throwException(new DecodeErrorException(0, 'parsing failed', '')));

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithoutEngineIosFail2(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::once())
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

        $device = $this->getMockBuilder(Device::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(Os::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('iOS');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $os = $this->createMock(Os::class);

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browser = $this->createMock(Browser::class);

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$browser, null]));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');
        $engineFactory
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::throwException(new NotFoundException('something not found')));

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertSame('testDevice', $result->getDevice()->getDeviceName());
        self::assertNull($result->getEngine()->getName());
        self::assertSame('iOS', $result->getOs()->getName());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserWithBrowserFactoryFail(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::exactly(2))
            ->method('debug');
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
            ->expects(self::once())
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

        $device = $this->getMockBuilder(Device::class)->getMock();
        $device->expects(self::once())
            ->method('getDeviceName')
            ->willReturn('testDevice');
        $os = $this->getMockBuilder(Os::class)->getMock();
        $os->expects(self::once())
            ->method('getName')
            ->willReturn('iOS');

        $deviceFactory = $this->getMockBuilder(DeviceFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $deviceFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue([$device, $os]));

        $os = $this->createMock(Os::class);

        $platformFactory = $this->getMockBuilder(PlatformFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $platformFactory
            ->expects(self::never())
            ->method('__invoke')
            ->with('testagent')
            ->will(self::returnValue($os));

        $browserFactory = $this->getMockBuilder(BrowserFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $browserFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('testagent')
            ->willThrowException(new DecodeErrorException(0, 'parsing failed', ''));

        $engineFactory = $this->getMockBuilder(EngineFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke', 'load'])
            ->getMock();
        $engineFactory
            ->expects(self::never())
            ->method('__invoke');

        $engine2 = $this->getMockBuilder(Engine::class)->getMock();
        $engine2->expects(self::once())
            ->method('getName')
            ->willReturn('webkit-test');

        $engineFactory
            ->expects(self::once())
            ->method('load')
            ->with('webkit', 'testagent')
            ->will(self::returnValue($engine2));

        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'getItem', 'setItem'])
            ->getMock();
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->willReturn(false);

        /** @var NullLogger $logger */
        /** @var Cache $cache */
        /** @var DeviceFactory $deviceFactory */
        /** @var PlatformFactory $platformFactory */
        /** @var BrowserFactory $browserFactory */
        /** @var EngineFactory $engineFactory */
        $object = new Detector($logger, $cache, $deviceFactory, $platformFactory, $browserFactory, $engineFactory);

        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => ['testagent']]);

        /* @var Result $result */
        $result = $object($message);

        self::assertInstanceOf(Result::class, $result);
        self::assertInstanceOf(Device::class, $result->getDevice());
        self::assertInstanceOf(Browser::class, $result->getBrowser());
        self::assertNull($result->getBrowser()->getName());
    }
}
