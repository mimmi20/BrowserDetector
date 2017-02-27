<?php


namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsMobileOs implements VersionCacheFactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public function detectVersion($useragent)
    {
        if (false !== strpos($useragent, 'Windows NT 5.1')) {
            return VersionFactory::set('6.0');
        }

        $s = new Stringy($useragent);

        if ($s->containsAny(['Windows Mobile', 'MSIEMobile'])) {
            $searches = ['MSIEMobile'];

            return VersionFactory::detectVersion($useragent, $searches, '6.0');
        }

        $searches = ['Windows Phone'];

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
