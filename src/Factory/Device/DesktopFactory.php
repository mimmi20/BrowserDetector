<?php


namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;
use BrowserDetector\Helper;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DesktopFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general desktop';

        if ((new Helper\Windows($useragent))->isWindows()) {
            $deviceCode = 'windows desktop';
        } elseif (preg_match('/Raspbian/', $useragent)) {
            $deviceCode = 'raspberry pi';
        } elseif (preg_match('/debian/i', $useragent) && preg_match('/rpi/', $useragent)) {
            $deviceCode = 'raspberry pi';
        } elseif ((new Helper\Linux($useragent))->isLinux()) {
            $deviceCode = 'linux desktop';
        } elseif (preg_match('/iMac/', $useragent)) {
            $deviceCode = 'imac';
        } elseif (preg_match('/macbookpro/i', $useragent)) {
            $deviceCode = 'macbook pro';
        } elseif (preg_match('/macbookair/i', $useragent)) {
            $deviceCode = 'macbook air';
        } elseif (preg_match('/macbook/i', $useragent)) {
            $deviceCode = 'macbook';
        } elseif (preg_match('/macmini/i', $useragent)) {
            $deviceCode = 'mac mini';
        } elseif (preg_match('/macpro/i', $useragent)) {
            $deviceCode = 'macpro';
        } elseif (preg_match('/(powermac|power%20macintosh)/i', $useragent)) {
            $deviceCode = 'powermac';
        } elseif ((new Helper\Macintosh($useragent))->isMacintosh()) {
            $deviceCode = 'macintosh';
        } elseif (preg_match('/eeepc/i', $useragent)) {
            $deviceCode = 'eee pc';
        } elseif (preg_match('/hp\-ux 9000/i', $useragent)) {
            $deviceCode = '9000';
        } elseif (preg_match('/Dillo/', $useragent)) {
            $deviceCode = 'linux desktop';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
