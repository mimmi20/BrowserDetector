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
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoader;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class EngineFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\EngineFactory
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
        $loader       = EngineLoader::getInstance();
        $this->object = new EngineFactory($loader);
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string      $userAgent
     * @param string|null $engine
     * @param string|null $version
     * @param string|null $manufacturer
     *
     * @return void
     */
    public function testDetect(string $userAgent, ?string $engine, ?string $version, ?string $manufacturer): void
    {
        $normalizer      = (new NormalizerFactory())->build();
        $normalizedUa    = $normalizer->normalize($userAgent);
        $browserLoader   = BrowserLoader::getInstance();
        $platformFactory = new PlatformFactory(PlatformLoader::getInstance());

        $s = new Stringy($normalizedUa);

        try {
            $platform = $platformFactory->detect($normalizedUa, $s);
        } catch (NotFoundException $e) {
            $platform = null;
        }

        /* @var \UaResult\Engine\EngineInterface $result */
        $result = $this->object->detect($normalizedUa, $s, $browserLoader, $platform);

        self::assertInstanceOf('\UaResult\Engine\EngineInterface', $result);
        self::assertSame(
            $engine,
            $result->getName(),
            'Expected engine name to be "' . $engine . '" (was "' . $result->getName() . '")'
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
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return json_decode(file_get_contents('tests/data/factory/engine.json'), true);
    }
}
