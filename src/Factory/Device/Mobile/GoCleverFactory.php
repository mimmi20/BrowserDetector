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
class GoCleverFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general goclever device';

        if (preg_match('/TQ700/', $useragent)) {
            $deviceCode = 'tq700';
        } elseif (preg_match('/TERRA\_101/', $useragent)) {
            $deviceCode = 'a1021';
        } elseif (preg_match('/INSIGNIA\_785\_PRO/', $useragent)) {
            $deviceCode = 'insignia 785 pro';
        } elseif (preg_match('/ARIES\_785/', $useragent)) {
            $deviceCode = 'aries 785';
        } elseif (preg_match('/ARIES\_101/', $useragent)) {
            $deviceCode = 'aries 101';
        } elseif (preg_match('/ORION7o/', $useragent)) {
            $deviceCode = 'orion 7o';
        } elseif (preg_match('/QUANTUM 4/', $useragent)) {
            $deviceCode = 'quantum 4';
        } elseif (preg_match('/QUANTUM_700m/', $useragent)) {
            $deviceCode = 'quantum 700m';
        } elseif (preg_match('/TAB A93\.2/', $useragent)) {
            $deviceCode = 'a93.2';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
