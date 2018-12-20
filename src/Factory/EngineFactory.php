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
namespace BrowserDetector\Factory;

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use Psr\Log\LoggerInterface;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

final class EngineFactory
{
    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * BrowserFactory constructor.
     *
     * @param \BrowserDetector\Loader\CompanyLoaderInterface   $companyLoader
     * @param \BrowserDetector\Version\VersionFactoryInterface $versionFactory
     */
    public function __construct(CompanyLoaderInterface $companyLoader, VersionFactoryInterface $versionFactory)
    {
        $this->companyLoader  = $companyLoader;
        $this->versionFactory = $versionFactory;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     * @param string                   $useragent
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function fromArray(LoggerInterface $logger, array $data, string $useragent): EngineInterface
    {
        $name = array_key_exists('name', $data) ? $data['name'] : null;

        $version      = $this->getVersion($data, $useragent);
        $manufacturer = $this->getCompany($logger, $data, $useragent, 'manufacturer');

        return new Engine($name, $manufacturer, $version);
    }

    use VersionFactoryTrait;
    use CompanyFactoryTrait;
}
