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
namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\Rules;
use JsonClass\Json;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class PlatformLoaderFactory
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $mode
     *
     * @return GenericLoaderInterface
     */
    public function __invoke(string $mode): GenericLoaderInterface
    {
        static $loaders = [];

        if (!array_key_exists($mode, $loaders)) {
            $dataPath  = __DIR__ . '/../../data/platforms';
            $rulesPath = __DIR__ . '/../../data/factories/platforms/' . $mode . '.json';

            $finder = new Finder();
            $finder->files();
            $finder->name('*.json');
            $finder->ignoreDotFiles(true);
            $finder->ignoreVCS(true);
            $finder->ignoreUnreadableDirs();
            $finder->in($dataPath);

            $json      = new Json();
            $file      = new SplFileInfo($rulesPath, '', '');
            $initRules = new Rules($file, $json);
            $initData  = new Data($finder, $json);

            $loader = new PlatformLoader(
                $this->logger,
                CompanyLoader::getInstance(),
                $initData
            );

            $loaders[$mode] = new GenericLoader(
                $this->logger,
                $initRules,
                $initData,
                $loader
            );
        }

        return $loaders[$mode];
    }
}
