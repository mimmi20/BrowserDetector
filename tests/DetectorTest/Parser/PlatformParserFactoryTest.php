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
/**
 * Created by PhpStorm.
 * User: Besitzer
 * Date: 23.12.2018
 * Time: 20:16
 */
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\PlatformParser;
use BrowserDetector\Parser\PlatformParserFactory;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class PlatformParserFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $logger        = $this->createMock(LoggerInterface::class);
        $jsonParser    = $this->createMock(JsonInterface::class);
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        $factory = new PlatformParserFactory($logger, $jsonParser, $companyLoader);

        $parser = $factory();

        self::assertInstanceOf(PlatformParserInterface::class, $parser);
        self::assertInstanceOf(PlatformParser::class, $parser);
    }
}
