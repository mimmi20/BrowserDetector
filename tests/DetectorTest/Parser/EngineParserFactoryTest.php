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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\EngineParser;
use BrowserDetector\Parser\EngineParserFactory;
use BrowserDetector\Parser\EngineParserInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

use function assert;

final class EngineParserFactoryTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     */
    public function testInvoke(): void
    {
        $logger        = $this->createMock(LoggerInterface::class);
        $jsonParser    = $this->createMock(JsonInterface::class);
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        assert($logger instanceof LoggerInterface);
        assert($jsonParser instanceof JsonInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        $factory = new EngineParserFactory($logger, $jsonParser, $companyLoader);

        $parser = $factory();

        self::assertInstanceOf(EngineParserInterface::class, $parser);
        self::assertInstanceOf(EngineParser::class, $parser);
    }
}
