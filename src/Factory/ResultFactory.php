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

use BrowserDetector\Version\Version;
use Psr\Log\LoggerInterface;
use UaDeviceType\Unknown;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Device\Market;
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UaResult\Result\Result;

final class ResultFactory
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Result\Result
     */
    public function fromArray(LoggerInterface $logger, array $data): Result
    {
        $headers = [];
        if (array_key_exists('headers', $data)) {
            $headers = (array) $data['headers'];
        }

        $device = new Device(
            null,
            null,
            new Company('Unknown', null, null),
            new Company('Unknown', null, null),
            new Unknown(),
            new Display(null, null, null, new \UaDisplaySize\Unknown(), null),
            false,
            0,
            new Market([], [], []),
            []
        );
        if (array_key_exists('device', $data)) {
            $device = (new DeviceFactory())->fromArray($logger, (array) $data['device']);
        }

        $browser = new Browser(
            null,
            new Company('Unknown', null, null),
            new Version('0'),
            new \UaBrowserType\Unknown(),
            0,
            null
        );
        if (array_key_exists('browser', $data)) {
            $browser = (new BrowserFactory())->fromArray($logger, (array) $data['browser']);
        }

        $os = new Os(
            null,
            null,
            new Company('Unknown', null, null),
            new Version('0'),
            null
        );
        if (array_key_exists('os', $data)) {
            $os = (new PlatformFactory())->fromArray($logger, (array) $data['os']);
        }

        $engine = new Engine(
            null,
            new Company('Unknown', null, null),
            new Version('0')
        );
        if (array_key_exists('engine', $data)) {
            $engine = (new EngineFactory())->fromArray($logger, (array) $data['engine']);
        }

        return new Result($headers, $device, $os, $browser, $engine);
    }
}
