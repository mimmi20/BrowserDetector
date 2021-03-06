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

namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

use function preg_match;

final class WindowsPhoneOs implements VersionDetectorInterface
{
    public const SEARCHES = ['Windows Phone OS', 'Windows Phone', 'Windows Mobile', 'Windows NT', 'WPOS\:'];

    private LoggerInterface $logger;

    private VersionFactoryInterface $versionFactory;

    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
    }

    /**
     * returns the version of the operating system/platform
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        if (preg_match('/xblwp7|zunewp7/i', $useragent)) {
            try {
                return $this->versionFactory->set('7.5.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (preg_match('/wds (?P<version>[\d.]+)/i', $useragent, $matches)) {
            try {
                return $this->versionFactory->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (preg_match('/wpdesktop/i', $useragent)) {
            if (preg_match('/windows nt 6\.3/i', $useragent)) {
                try {
                    return $this->versionFactory->set('8.1.0');
                } catch (NotNumericException $e) {
                    $this->logger->info($e);
                }
            }

            if (preg_match('/windows nt 6\.2/i', $useragent)) {
                try {
                    return $this->versionFactory->set('8.0.0');
                } catch (NotNumericException $e) {
                    $this->logger->info($e);
                }
            }

            return new NullVersion();
        }

        try {
            return $this->versionFactory->detectVersion($useragent, self::SEARCHES);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
