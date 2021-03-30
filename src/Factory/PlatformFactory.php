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

namespace BrowserDetector\Factory;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use UaResult\Company\Company;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function array_key_exists;
use function assert;
use function is_int;
use function is_string;
use function version_compare;

final class PlatformFactory
{
    use VersionFactoryTrait;

    private CompanyLoaderInterface $companyLoader;

    public function __construct(CompanyLoaderInterface $companyLoader, VersionFactoryInterface $versionFactory)
    {
        $this->companyLoader  = $companyLoader;
        $this->versionFactory = $versionFactory;
    }

    /**
     * @param array<string, (string|stdClass|int|null)> $data
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function fromArray(LoggerInterface $logger, array $data, string $useragent): OsInterface
    {
        assert(array_key_exists('name', $data), '"name" property is required');
        assert(array_key_exists('marketingName', $data), '"marketingName" property is required');
        assert(array_key_exists('manufacturer', $data), '"manufacturer" property is required');
        assert(array_key_exists('version', $data), '"version" property is required');
        assert(array_key_exists('bits', $data), '"bits" property is required');

        $name          = $data['name'];
        $marketingName = $data['marketingName'];
        $bits          = $data['bits'];

        assert(!is_int($data['version']));
        $version = $this->getVersion($data['version'], $useragent, $logger);

        assert(is_string($name) || null === $name);
        assert(is_string($marketingName) || null === $marketingName);
        assert(is_int($bits) || null === $bits);
        assert(is_string($data['manufacturer']));

        try {
            $manufacturer = $this->companyLoader->load($data['manufacturer'], $useragent);
        } catch (NotFoundException $e) {
            $logger->info($e);

            $manufacturer = new Company(
                'unknown',
                null,
                null
            );
        }

        if (null !== $version->getVersion(VersionInterface::IGNORE_MICRO)) {
            if (
                'Mac OS X' === $name
                && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '10.12', '>=')
            ) {
                $name          = 'macOS';
                $marketingName = 'macOS';
            } elseif (
                'iOS' === $name
                && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '4.0', '<')
                && version_compare($version->getVersion(VersionInterface::IGNORE_MICRO), '0.0', '>')
            ) {
                $name          = 'iPhone OS';
                $marketingName = 'iPhone OS';
            }
        }

        return new Os($name, $marketingName, $manufacturer, $version, $bits);
    }
}
