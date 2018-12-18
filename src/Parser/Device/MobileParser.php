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
namespace BrowserDetector\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use JsonClass\JsonInterface;

final class MobileParser implements DeviceParserInterface
{
    /**
     * @var \BrowserDetector\Loader\DeviceLoaderFactoryInterface
     */
    private $loaderFactory;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    private const GENERIC_FILE  = '/../../../data/factories/devices/mobile.json';
    private const SPECIFIC_FILE = '/../../../data/factories/devices/mobile/%s.json';

    /**
     * @param \JsonClass\JsonInterface                             $jsonParser
     * @param \BrowserDetector\Loader\DeviceLoaderFactoryInterface $loaderFactory
     */
    public function __construct(JsonInterface $jsonParser, DeviceLoaderFactoryInterface $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
        $this->jsonParser    = $jsonParser;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $useragent
     *
     * @throws \ExceptionalJSON\DecodeErrorException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $factories = $this->jsonParser->decode(
            (string) file_get_contents(__DIR__ . self::GENERIC_FILE),
            true
        );
        $mode = $factories['generic'];

        foreach (array_keys($factories['rules']) as $rule) {
            if (preg_match($rule, $useragent)) {
                $mode = $factories['rules'][$rule];
                break;
            }
        }

        $specFactories = $this->jsonParser->decode(
            (string) file_get_contents(__DIR__ . sprintf(self::SPECIFIC_FILE, $mode)),
            true
        );
        $key = $specFactories['generic'];

        foreach (array_keys($specFactories['rules']) as $rule) {
            if (preg_match($rule, $useragent)) {
                $key = $specFactories['rules'][$rule];
                break;
            }
        }

        return $this->load($mode, $key, $useragent);
    }

    /**
     * @param string $company
     * @param string $key
     * @param string $useragent
     *
     * @return array
     */
    public function load(string $company, string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\DeviceLoader $loader */
        $loader = $loaderFactory($company);

        return $loader($key, $useragent);
    }
}
