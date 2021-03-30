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

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoaderFactoryInterface;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use SplFileInfo;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function assert;
use function get_class;
use function sprintf;

final class PlatformParser implements PlatformParserInterface
{
    private const GENERIC_FILE  = __DIR__ . '/../../data/factories/platforms.json';
    private const SPECIFIC_FILE = __DIR__ . '/../../data/factories/platforms/%s.json';
    private PlatformLoaderFactoryInterface $loaderFactory;

    private RulefileParserInterface $fileParser;

    public function __construct(
        PlatformLoaderFactoryInterface $loaderFactory,
        RulefileParserInterface $fileParser
    ) {
        $this->loaderFactory = $loaderFactory;
        $this->fileParser    = $fileParser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): OsInterface
    {
        $mode = $this->fileParser->parseFile(
            new SplFileInfo(self::GENERIC_FILE),
            $useragent,
            'unknown'
        );

        $key = $this->fileParser->parseFile(
            new SplFileInfo(sprintf(self::SPECIFIC_FILE, $mode)),
            $useragent,
            'unknown'
        );

        return $this->load($key, $useragent);
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): OsInterface
    {
        $loaderFactory = $this->loaderFactory;

        $loader = $loaderFactory();
        assert($loader instanceof PlatformLoaderInterface, sprintf('$loader should be an instance of %s, but is %s', PlatformLoaderInterface::class, get_class($loader)));

        return $loader->load($key, $useragent);
    }
}
