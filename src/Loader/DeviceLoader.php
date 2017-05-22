<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Loader;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use UaDeviceType\TypeLoader;
use UaResult\Company\CompanyLoader;
use UaResult\Device\Device;

/**
 * Device detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DeviceLoader implements LoaderInterface
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
        $cacheInitializedId = hash('sha512', 'device-cache is initialized');
        $cacheInitialized   = $this->cache->getItem($cacheInitializedId);

        if (!$cacheInitialized->isHit() || !$cacheInitialized->get()) {
            $this->initCache($cacheInitialized);
        }
    }

    /**
     * @param string $deviceKey
     *
     * @return bool
     */
    public function has($deviceKey)
    {
        $this->init();

        $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));

        return $cacheItem->isHit();
    }

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function load($deviceKey, $useragent = '')
    {
        $this->init();

        if (!$this->has($deviceKey)) {
            throw new NotFoundException('the device with key "' . $deviceKey . '" was not found');
        }

        $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));

        $device      = $cacheItem->get();
        $platformKey = $device->platform;

        if (null === $platformKey) {
            $platform = null;
        } else {
            $platform = (new PlatformLoader($this->cache))->load($platformKey, $useragent);
        }

        $companyLoader = new CompanyLoader($this->cache);

        $device = new Device(
            $device->codename,
            $device->marketingName,
            $companyLoader->load($device->manufacturer),
            $companyLoader->load($device->brand),
            (new TypeLoader($this->cache))->load($device->type),
            $device->pointingMethod,
            $device->resolutionWidth,
            $device->resolutionHeight,
            $device->dualOrientation
        );

        return [$device, $platform];
    }

    /**
     * @param \Psr\Cache\CacheItemInterface $cacheInitialized
     */
    private function initCache(CacheItemInterface $cacheInitialized)
    {
        $sourceDirectory = __DIR__ . '/../../data/devices/';
        $iterator        = new \RecursiveDirectoryIterator($sourceDirectory);

        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile() || $file->getExtension() !== 'json') {
                continue;
            }

            $devices = json_decode(file_get_contents($file->getPathname()));

            foreach ($devices as $deviceKey => $deviceData) {
                $cacheItem = $this->cache->getItem(hash('sha512', 'device-cache-' . $deviceKey));
                $cacheItem->set($deviceData);

                $this->cache->save($cacheItem);
            }
        }

        $cacheInitialized->set(true);
        $this->cache->save($cacheInitialized);
    }
}
