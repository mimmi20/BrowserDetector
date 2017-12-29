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
namespace BrowserDetectorTest\Factory\Platform;

use BrowserDetector\Factory\Platform\DarwinFactory;
use BrowserDetector\Loader\PlatformLoader;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Stringy\Stringy;
use Symfony\Component\Cache\Simple\FilesystemCache;

class DarwinFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\Platform\DarwinFactory
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
        $cache        = new FilesystemCache('', 0, __DIR__ . '/../../../cache/');
        $logger       = new NullLogger();
        $loader       = PlatformLoader::getInstance($cache, $logger);
        $this->object = new DarwinFactory($loader);
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string      $agent
     * @param string|null $platform
     * @param string|null $version
     * @param string|null $manufacturer
     * @param int|null    $bits
     *
     * @throws \Psr\Cache\InvalidArgumentException
     *
     * @return void
     */
    public function testDetect(string $agent, ?string $platform, ?string $version, ?string $manufacturer, ?int $bits): void
    {
        $s = new Stringy($agent);

        /* @var \UaResult\Os\OsInterface $result */
        $result = $this->object->detect($agent, $s);

        self::assertInstanceOf('\UaResult\Os\OsInterface', $result);
        self::assertSame(
            $platform,
            $result->getName(),
            'Expected platform name to be "' . $platform . '" (was "' . $result->getName() . '")'
        );

        self::assertInstanceOf('\BrowserDetector\Version\Version', $result->getVersion());
        self::assertSame(
            $version,
            $result->getVersion()->getVersion(),
            'Expected version to be "' . $version . '" (was "' . $result->getVersion()->getVersion() . '")'
        );

        self::assertSame(
            $manufacturer,
            $result->getManufacturer()->getName(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
        );

        self::assertSame(
            $bits,
            $result->getBits(),
            'Expected bits count to be "' . $bits . '" (was "' . $result->getBits() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return json_decode(file_get_contents('tests/data/factory/platform/darwin.json'), true);
    }
}
