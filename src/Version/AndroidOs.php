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

final class AndroidOs implements VersionDetectorInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @throws \UnexpectedValueException
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        if (false !== mb_stripos($useragent, 'android 2.1-update1')) {
            return (new VersionFactory())->set('2.1.1');
        }

        $search = [
            'android android',
            'android androidhouse team',
            'android wildpuzzlerom v8 froyo',
            'juc ?\(linux;',
            'linux; googletv',
            'android ouya',
            'android os',
            'andr[0o]id[;_ ]',
            'andr[0o]id\/',
            'andr[0o]id',
            'adr ',
            '\(os: ',
        ];

        $detectedVersion = (new VersionFactory())->detectVersion($useragent, $search);

        if ('0.0.0' !== $detectedVersion->getVersion()) {
            return $detectedVersion;
        }

        if ((bool) preg_match('/Linux; (?P<version>\d+[\d\.]+)/', $useragent, $matches)) {
            return (new VersionFactory())->set($matches['version']);
        }

        if (false !== mb_stripos($useragent, 'gingerbread')) {
            return (new VersionFactory())->set('2.3.0');
        }

        if (false !== mb_stripos($useragent, 'android eclair')) {
            return (new VersionFactory())->set('2.1.0');
        }

        return new Version('0');
    }
}
