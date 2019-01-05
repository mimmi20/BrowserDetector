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
namespace BrowserDetectorTest\Parser\Helper;

use BrowserDetector\Parser\Helper\RulefileParser;
use JsonClass\JsonInterface;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class RulefileParserTest extends TestCase
{
    private const DATA_PATH = 'root';

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    private $root;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $structure = [
            'bot.json' => 'test-content',
        ];

        $this->root = vfsStream::setup(self::DATA_PATH, null, $structure);
    }

    /**
     * @return void
     */
    public function testParseEmptyFile(): void
    {
        $content  = 'test-content';
        $fallback = 'test-fallback';

        $fileInfo = $this->getMockBuilder(\SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::once())
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willReturn([]);

        $useragent = 'test-useragent';

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

        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \Psr\Log\LoggerInterface $logger */
        $object = new RulefileParser($jsonParser, $logger);

        /** @var \SplFileInfo $fileInfo */
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($fallback, $result);
    }

    /**
     * @return void
     */
    public function testParseFileError(): void
    {
        $content   = 'test-content';
        $fallback  = 'test-fallback';
        $exception = new \RuntimeException('read-error');

        $fileInfo = $this->getMockBuilder(\SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::once())
            ->method('getPathname')
            ->willThrowException($exception);

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::never())
            ->method('decode')
            ->with($content, true)
            ->willReturn([]);

        $useragent = 'test-useragent';

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
            ->expects(self::once())
            ->method('error')
            ->with($exception);
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \Psr\Log\LoggerInterface $logger */
        $object = new RulefileParser($jsonParser, $logger);

        /** @var \SplFileInfo $fileInfo */
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($fallback, $result);
    }

    /**
     * @return void
     */
    public function testParseNotEmptyFile(): void
    {
        $content  = 'test-content';
        $fallback = 'test-fallback';
        $mode     = 'test-mode';

        $generic = 'test-generic';
        $rules   = ['/test-useragent/' => $mode, '/test/' => 'test-mode-2'];

        $fileInfo = $this->getMockBuilder(\SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::once())
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willReturn(['generic' => $generic, 'rules' => $rules]);

        $useragent = 'test-useragent';

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

        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \Psr\Log\LoggerInterface $logger */
        $object = new RulefileParser($jsonParser, $logger);

        /** @var \SplFileInfo $fileInfo */
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($mode, $result);
    }

    /**
     * @return void
     */
    public function testParseNotEmptyFile2(): void
    {
        $content  = 'test-content';
        $fallback = 'test-fallback';
        $mode     = 'test-mode';

        $generic = 'test-generic';
        $rules   = ['/test-useragent/' => $mode, '/test/' => 'test-mode-2'];

        $fileInfo = $this->getMockBuilder(\SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::once())
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willReturn(['generic' => $generic, 'rules' => $rules]);

        $useragent = 'tets-useragent';

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

        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \Psr\Log\LoggerInterface $logger */
        $object = new RulefileParser($jsonParser, $logger);

        /** @var \SplFileInfo $fileInfo */
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($generic, $result);
    }
}
