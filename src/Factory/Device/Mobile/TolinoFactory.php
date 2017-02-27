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
class TolinoFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general tolino device';

        if (preg_match('/tab 8\.9/i', $useragent)) {
            $deviceCode = 'tab 8.9';
        } elseif (preg_match('/tab 8/i', $useragent)) {
            $deviceCode = 'tab 8';
        } elseif (preg_match('/tab 7/i', $useragent)) {
            $deviceCode = 'tab 7';
        } elseif (preg_match('/tolino/i', $useragent)) {
            $deviceCode = 'tolino shine';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
