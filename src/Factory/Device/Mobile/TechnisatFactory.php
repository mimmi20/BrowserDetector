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
class TechnisatFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general technisat device';

        if (preg_match('/TechniPad[_ ]10\-3G/', $useragent)) {
            $deviceCode = 'technipad 10 3g';
        } elseif (preg_match('/TechniPad[_ ]10/', $useragent)) {
            $deviceCode = 'technipad 10';
        } elseif (preg_match('/AQIPAD[_ ]7G/', $useragent)) {
            $deviceCode = 'aqiston aqipad 7g';
        } elseif (preg_match('/TechniPhone[_ ]5/', $useragent)) {
            $deviceCode = 'techniphone 5';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
