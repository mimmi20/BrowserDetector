<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Version\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaResult\Browser\BrowserInterface;
use UaResult\Engine\EngineInterface;

final class BrowserLoaderTest extends TestCase
{
    /**
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(false);
        $initData
            ->expects(self::never())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(false);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        \assert($logger instanceof LoggerInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        \assert($engineParser instanceof EngineParserInterface);
        \assert($initData instanceof DataInterface);
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
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);
        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(null);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        \assert($logger instanceof LoggerInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        \assert($engineParser instanceof EngineParserInterface);
        \assert($initData instanceof DataInterface);
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
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $browserData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => null,
            'name' => null,
            'modus' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        \assert($logger instanceof LoggerInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        \assert($engineParser instanceof EngineParserInterface);
        \assert($initData instanceof DataInterface);
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
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $browserData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => null,
            'modus' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        \assert($logger instanceof LoggerInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        \assert($engineParser instanceof EngineParserInterface);
        \assert($initData instanceof DataInterface);
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
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $useragent   = 'test/1.0';
        $engineKey   = 'unknown';
        $browserData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => $engineKey,
            'name' => null,
            'modus' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

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

        \assert($logger instanceof LoggerInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        \assert($engineParser instanceof EngineParserInterface);
        \assert($initData instanceof DataInterface);
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
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
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
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $browserData = (object) [
            'version' => (object) ['class' => Test::class],
            'manufacturer' => 'unknown',
            'type' => 'unknown',
            'engine' => 'unknown',
            'name' => 'test-browser',
            'modus' => null,
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($browserData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $engineParser = $this->getMockBuilder(EngineParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        \assert($logger instanceof LoggerInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        \assert($engineParser instanceof EngineParserInterface);
        \assert($initData instanceof DataInterface);
        $object = new BrowserLoader(
            $logger,
            $initData,
            $companyLoader,
            $engineParser
        );

        $result = $object->load('test-key', 'test/1.0');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        $browserResult = $result[0];
        \assert($browserResult instanceof BrowserInterface, sprintf('$browserResult should be an instance of %s, but is %s', BrowserInterface::class, get_class($browserResult)));
        self::assertInstanceOf(BrowserInterface::class, $browserResult);
        self::assertArrayHasKey(1, $result);
        $engineResult = $result[1];
        \assert($engineResult instanceof EngineInterface, sprintf('$engineResult should be an instance of %s, but is %s', EngineInterface::class, get_class($engineResult)));
        self::assertInstanceOf(EngineInterface::class, $engineResult);

        self::assertSame('test-browser', $browserResult->getName());
    }
}
