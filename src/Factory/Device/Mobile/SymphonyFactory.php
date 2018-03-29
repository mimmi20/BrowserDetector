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
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class SymphonyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'h150' => 'symphony h150',
        'i10'  => 'symphony i10',
        'w82'  => 'symphony w82',
        'l102' => 'symphony l102',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general symphony device';

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s): array
    {
        $regex = '/(' . implode('|', array_map('preg_quote', array_keys($this->devices))) . ')/i';

        $matches = [];

        if (preg_match($regex, $useragent, $matches)) {
            $key = $this->devices[mb_strtolower($matches[1])];

            if ($this->loader->has($key)) {
                return $this->loader->load($key, $useragent);
            }
        }

        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load($this->genericDevice, $useragent);
    }
}
