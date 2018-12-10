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
namespace BrowserDetector\Version;

final class FirefoxOs implements VersionDetectorInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        if (!preg_match('/rv:(\d+\.\d+)/', $useragent, $matches)) {
            return new Version('0');
        }

        $version = (float) $matches[1];

        if (44.0 <= $version) {
            return new Version('2', '5');
        }

        if (37.0 <= $version) {
            return new Version('2', '2');
        }

        if (34.0 <= $version) {
            return new Version('2', '1');
        }

        if (32.0 <= $version) {
            return new Version('2', '0');
        }

        if (30.0 <= $version) {
            return new Version('1', '4');
        }

        if (28.0 <= $version) {
            return new Version('1', '3');
        }

        if (26.0 <= $version) {
            return new Version('1', '2');
        }

        if (18.1 <= $version) {
            return new Version('1', '1');
        }

        if (18.0 <= $version) {
            return new Version('1', '0');
        }

        return new Version('0');
    }
}
