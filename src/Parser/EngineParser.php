<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

use BrowserDetector\Loader\EngineLoaderFactoryInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use UaResult\Engine\EngineInterface;

final class EngineParser implements EngineParserInterface
{
    /** @var \BrowserDetector\Loader\EngineLoaderFactoryInterface */
    private $loaderFactory;

    /** @var \BrowserDetector\Parser\Helper\RulefileParserInterface */
    private $fileParser;

    private const GENERIC_FILE = __DIR__ . '/../../data/factories/engines.json';

    /**
     * @param \BrowserDetector\Loader\EngineLoaderFactoryInterface   $loaderFactory
     * @param \BrowserDetector\Parser\Helper\RulefileParserInterface $fileParser
     */
    public function __construct(
        EngineLoaderFactoryInterface $loaderFactory,
        RulefileParserInterface $fileParser
    ) {
        $this->loaderFactory = $loaderFactory;
        $this->fileParser    = $fileParser;
    }

    /**
     * Gets the information about the engine by User Agent
     *
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function parse(string $useragent): EngineInterface
    {
        $key = $this->fileParser->parseFile(
            new \SplFileInfo(self::GENERIC_FILE),
            $useragent,
            'unknown'
        );

        return $this->load($key, $useragent);
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return EngineInterface
     */
    public function load(string $key, string $useragent = ''): EngineInterface
    {
        $loaderFactory = $this->loaderFactory;

        $loader = $loaderFactory();
        \assert($loader instanceof EngineLoaderInterface, sprintf('$loader should be an instance of %s, but is %s', EngineLoaderInterface::class, get_class($loader)));

        return $loader->load($key, $useragent);
    }
}
