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

class SunstechFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tab917qc-8gb' => 'sunstech tab917qc 8gb',
        'tab785dual'   => 'sunstech tab785 dual',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general sunstech device';

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
