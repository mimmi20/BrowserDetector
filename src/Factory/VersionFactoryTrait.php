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

use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use Psr\Log\LoggerInterface;
use stdClass;

use function is_array;
use function is_string;

trait VersionFactoryTrait
{
    private VersionFactoryInterface $versionFactory;

    /**
     * @param stdClass|string|null $version
     */
    private function getVersion($version, string $useragent, LoggerInterface $logger): VersionInterface
    {
        if (is_string($version)) {
            return $this->versionFactory->set($version);
        }

        $versionClass = new NullVersion();

        if (null === $version) {
            return $versionClass;
        }

        $value = $version->value ?? null;

        if (null !== $value) {
            return $this->versionFactory->set((string) $value);
        }

        $className   = $version->class ?? null;
        $factoryName = $version->factory ?? null;

        if (!is_string($className) && !is_string($factoryName)) {
            return $versionClass;
        }

        if (is_string($factoryName)) {
            $factory         = new $factoryName();
            $versionDetector = $factory($logger);

            return $versionDetector->detectVersion($useragent);
        }

        if ('VersionFactory' !== $className) {
            $versionDetector = new $className();

            return $versionDetector->detectVersion($useragent);
        }

        if (!is_array($version->search ?? null)) {
            return $versionClass;
        }

        return $this->versionFactory->detectVersion($useragent, $version->search);
    }
}
