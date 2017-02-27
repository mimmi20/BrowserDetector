<?php


namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TriQFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return array
     */
    public function detect($useragent)
    {
        $deviceCode = 'general 3q device';

        if (preg_match('/QS0716D/', $useragent)) {
            $deviceCode = 'qs0716d';
        } elseif (preg_match('/MT0812E/', $useragent)) {
            $deviceCode = 'mt0812e';
        } elseif (preg_match('/MT0739D/', $useragent)) {
            $deviceCode = 'mt0739d';
        } elseif (preg_match('/AC0732C/', $useragent)) {
            $deviceCode = 'ac0732c';
        } elseif (preg_match('/RC9724C/', $useragent)) {
            $deviceCode = 'rc9724c';
        } elseif (preg_match('/LC0720C/', $useragent)) {
            $deviceCode = 'lc0720c';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
