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
class RitmixFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general ritmix device';

        if (preg_match('/RMD\-1040/', $useragent)) {
            $deviceCode = 'rmd-1040';
        } elseif (preg_match('/RMD\-1028/', $useragent)) {
            $deviceCode = 'rmd-1028';
        } elseif (preg_match('/RMD\-1025/', $useragent)) {
            $deviceCode = 'rmd-1025';
        } elseif (preg_match('/RMD\-757/', $useragent)) {
            $deviceCode = 'rmd-757';
        } elseif (preg_match('/RMD\-753/', $useragent)) {
            $deviceCode = 'rmd-753';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
