<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

final class MicrosoftInternetExplorer implements VersionDetectorInterface
{
    private const VERSIONS = [
        '8' => '11.0',
        '7' => '11.0',
        '6' => '10.0',
        '5' => '9.0',
        '4' => '8.0',
    ];

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var VersionFactory
     */
    private $versionFactory;

    /**
     * @var \BrowserDetector\Version\Trident
     */
    private $trident;

    /**
     * ChromeOs constructor.
     *
     * @param \Psr\Log\LoggerInterface                $logger
     * @param \BrowserDetector\Version\VersionFactory $versionFactory
     * @param Trident                                 $trident
     */
    public function __construct(LoggerInterface $logger, VersionFactory $versionFactory, Trident $trident)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
        $this->trident        = $trident;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $version = $this->trident->detectVersion($useragent);

        foreach (self::VERSIONS as $engineVersion => $ieVersion) {
            if (version_compare($version->getMajor(), (string) $engineVersion, '>=')) {
                try {
                    return $this->versionFactory->set($ieVersion);
                } catch (NotNumericException $e) {
                    $this->logger->info($e);
                }
            }
        }

        $doMatch = preg_match('/MSIE (?P<version>[\d\.]+)/', $useragent, $matches);

        if (0 < $doMatch) {
            try {
                return $this->versionFactory->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
