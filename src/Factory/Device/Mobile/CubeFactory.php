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
class CubeFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general cube device';

        if (preg_match('/u55gt/i', $useragent)) {
            $deviceCode = 'u55gt';
        } elseif (preg_match('/u51gt/i', $useragent)) {
            $deviceCode = 'u51gt';
        } elseif (preg_match('/u30gt 2/i', $useragent)) {
            $deviceCode = 'u30gt2';
        } elseif (preg_match('/u30gt/i', $useragent)) {
            $deviceCode = 'u30gt';
        } elseif (preg_match('/u25gt\-c4w/i', $useragent)) {
            $deviceCode = 'u25gt-c4w';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
