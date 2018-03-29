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

class TmobileFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'pulse'             => 't-mobile pulse',
        'mytouch4g'         => 't-mobile mytouch4g',
        'mytouch 3g slide'  => 't-mobile mytouch3g',
        't-mobile_g2_touch' => 't-mobile g2 touch',
        't-mobile g2'       => 't-mobile g2 touch',
        't-mobile g1'       => 't-mobile g1',
        'garminfone'        => 't-mobile garminfone',
        'ameo'              => 't-mobile ameo',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general t-mobile device';

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
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load($this->genericDevice, $useragent);
    }
}
