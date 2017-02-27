<?php


namespace BrowserDetector\Loader;

use BrowserDetector\Bits\Browser as BrowserBits;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use UaBrowserType\TypeLoader;
use UaResult\Browser\Browser;
use UaResult\Company\CompanyLoader;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserLoader implements LoaderInterface
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
     * initializes cache
     */
    private function init()
    {
        $cacheInitializedId = hash('sha512', 'browser-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * @param string $browserKey
     *
     * @return bool
     */
    public function has($browserKey)
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));

        return $cacheItem->isHit();
    }

    /**
     * @param string $browserKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @return array
     */
    public function load($browserKey, $useragent = '')
    {
        $this->init();

        if (!$this->has($browserKey)) {
            throw new NotFoundException('the browser with key "' . $browserKey . '" was not found');
        }

        $engineLoader = new EngineLoader($this->cache);
        $cacheItem    = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));

        $browser = $cacheItem->get();

        $browserVersionClass = $browser->version->class;

        if (!is_string($browserVersionClass)) {
            $version = new Version(0);
        } elseif ('VersionFactory' === $browserVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $browser->version->search);
        } else {
            /** @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $browserVersionClass($this->cache);
            $version      = $versionClass->detectVersion($useragent);
        }

        return [
            new Browser(
                $browser->name,
                (new CompanyLoader($this->cache))->load($browser->manufacturer),
                $version,
                (new TypeLoader($this->cache))->load($browser->type),
                (new BrowserBits($useragent))->getBits(),
                $browser->pdfSupport,
                $browser->rssSupport
            ),
            $engineLoader->load($browser->engine, $useragent),
        ];
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     */
    private function initCache(CacheItemInterface $cacheInitialized)
    {
        static $browsers = null;

        if (null === $browsers) {
            $browsers = json_decode(file_get_contents(__DIR__ . '/../../data/browsers.json'));
        }

        foreach ($browsers as $browserKey => $browserData) {
            $cacheItem = $this->cache->getItem(hash('sha512', 'browser-cache-' . $browserKey));
            $cacheItem->set($browserData);

            $this->cache->save($cacheItem);
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
