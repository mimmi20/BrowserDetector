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
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaResult\Browser\BrowserInterface;
use UaResult\Engine\EngineInterface;

class BrowserLoaderTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeNotInCache(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(false);

        $initData
            ->expects(self::never())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue(false));

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the browser with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNullInCache(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue(null));

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the browser with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @return void
     */
    public function testInvokeNoVersion(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $browserData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'Unknown',
            'type' => 'unknown',
            'engine' => null,
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($browserData));

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', 'test-ua');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(BrowserInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersionAndEngineException(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $browserData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'Unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($browserData));

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', 'test/1.0');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(BrowserInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertInstanceOf(EngineInterface::class, $result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeGenericVersionAndEngineInvalidException(): void
    {
        $exception = new NotFoundException('engine failed');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
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
            ->expects(self::once())
            ->method('warning')
            ->with($exception);
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $useragent   = 'test/1.0';
        $engineKey   = 'unknown';
        $browserData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'Unknown',
            'type' => 'unknown',
            'engine' => $engineKey,
            'name' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($browserData));

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $engineParser
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $useragent)
            ->willThrowException($exception);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', $useragent);

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(BrowserInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @return void
     */
    public function testInvokeVersionAndEngine(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->will(self::returnValue(true));

        $browserData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'Unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => 'test-browser',
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->will(self::returnValue($browserData));

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var CompanyLoaderInterface $companyLoader */
        /** @var EngineParserInterface $engineParser */
        /** @var Data $initData */
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', 'test/1.0');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        /** @var BrowserInterface $browserResult */
        $browserResult = $result[0];
        self::assertInstanceOf(BrowserInterface::class, $browserResult);
        self::assertArrayHasKey(1, $result);
        /** @var EngineInterface $engineResult */
        $engineResult = $result[1];
        self::assertInstanceOf(EngineInterface::class, $engineResult);

        self::assertSame('test-browser', $browserResult->getName());
    }
}
