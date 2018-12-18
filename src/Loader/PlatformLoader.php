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

use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\Helper\DataInterface;
use Psr\Log\LoggerInterface;
use UaResult\Os\OsInterface;

final class PlatformLoader implements SpecificLoaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Loader\Helper\DataInterface
     */
    private $initData;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \BrowserDetector\Loader\Helper\DataInterface   $initData
     * @param \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader
     */
    public function __construct(
        LoggerInterface $logger,
        DataInterface $initData,
        CompanyLoaderInterface $companyLoader
    ) {
        $this->logger        = $logger;
        $this->companyLoader = $companyLoader;

        $initData();

        $this->initData = $initData;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Os\OsInterface
     */
    public function __invoke(string $key, string $useragent = ''): OsInterface
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        $platformData = $this->initData->getItem($key);

        if (null === $platformData) {
            throw new NotFoundException('the platform with key "' . $key . '" was not found');
        }

        return (new PlatformFactory($this->companyLoader))->fromArray($this->logger, (array) $platformData, $useragent);
    }
}
