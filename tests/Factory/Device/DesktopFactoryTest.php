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
namespace BrowserDetectorTest\Factory\Device;

use BrowserDetector\Factory\Device\DesktopFactory;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetectorTest\Factory\DeviceTestDetectTrait;

/**
 * Test class for \BrowserDetector\Detector\Device\Desktop\GeneralDesktop
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class DesktopFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\DesktopFactory
     */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $loader       = DeviceLoader::getInstance();
        $this->object = new DesktopFactory($loader);
    }

    use DeviceTestDetectTrait;

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        $sourceDirectory = 'tests/data/factory/device/desktop/';
        $iterator        = new \RecursiveDirectoryIterator($sourceDirectory);

        $tests = [];

        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            /* @var $file \SplFileInfo */
            if (!$file->isFile() || 'json' !== $file->getExtension()) {
                continue;
            }

            $subfileTests = json_decode(file_get_contents($file->getPathname()), true);

            foreach ($subfileTests as $subfileTest) {
                if ('this is a fake ua to trigger the fallback' === $subfileTest['ua']) {
                    continue;
                }

                $tests[$subfileTest['ua']] = $subfileTest;
            }
        }

        $fileTests = json_decode(file_get_contents('tests/data/factory/device/desktop.json'), true);

        foreach ($fileTests as $fileTest) {
            if (array_key_exists($fileTest['ua'], $tests)) {
                continue;
            }

            $tests[$fileTest['ua']] = $fileTest;
        }

        return $tests;
    }
}
