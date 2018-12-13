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
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\EngineParserInterface;
use JsonClass\Json;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class BrowserParserTest extends TestCase
{
    /**
     * @var \BrowserDetector\Parser\BrowserParser
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $logger = $this->createMock(NullLogger::class);
        $jsonParser = $this->createMock(JsonInterface::class);
        $engineParser = $this->createMock(EngineParserInterface::class);

        /** @var NullLogger $logger */
        /** @var Json $jsonParser */
        /** @var EngineParserInterface $engineParser */
        $this->object = new BrowserParser($logger, $jsonParser, $engineParser);
    }

    /**
     * @dataProvider providerUseragents
     *
     * @param string $useragent
     * @param string $expectedMode
     * @param array  $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testInvoke(string $useragent, string $expectedMode, array $expectedResult): void
    {
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
            ->with($expectedMode)
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
                'Mozilla/5.0 (Windows IoT 10.0; Android 6.0.1; WebView/3.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Mobile Safari/537.36 Edge/17.17083',
                'edge',
                [],
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1.1; Z110 Build/LMY48B; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 Safari/537.36',
                'blink',
                [],
            ],
            [
                'this is a fake ua to trigger the fallback',
                'genericbrowser',
                [],
            ],
        ];
    }
}
