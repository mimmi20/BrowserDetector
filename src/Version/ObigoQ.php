<?php


namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ObigoQ implements VersionCacheFactoryInterface
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
        $doMatch = preg_match(
            '/ObigoInternetBrowser\/Q(\d+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        $doMatch = preg_match(
            '/obigo\-browser\/Q(\d+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        $searches = [
            'Teleca\-Q',
            'Obigo\-Q',
            'Obigo\/Q',
            'Teleca\/Q',
        ];

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
