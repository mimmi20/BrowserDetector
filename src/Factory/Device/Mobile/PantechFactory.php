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
class PantechFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general pantech device';

        if (preg_match('/p9020/i', $useragent)) {
            $deviceCode = 'p9020';
        } elseif (preg_match('/p2020/i', $useragent)) {
            $deviceCode = 'p2020';
        } elseif (preg_match('/im\-a900k/i', $useragent)) {
            $deviceCode = 'im-a900k';
        } elseif (preg_match('/im\-a830l/i', $useragent)) {
            $deviceCode = 'im-a830l';
        } elseif (preg_match('/pt\-gf200/i', $useragent)) {
            $deviceCode = 'pt-gf200';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
