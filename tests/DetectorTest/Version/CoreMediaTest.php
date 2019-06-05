<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\CoreMedia;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;

final class CoreMediaTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\CoreMedia
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new CoreMedia();
    }

    /**
     * @dataProvider providerVersion
     *
     * @param string $useragent
     * @param string $expectedVersion
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testTestdetectVersion(string $useragent, string $expectedVersion): void
    {
        $detectedVersion = $this->object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array[]
     */
    public function providerVersion(): array
    {
        return [
            [
                'AppleCoreMedia/1.0.2.12D508 (iPad; U; CPU OS 8_2 like Mac OS X; sv_se)',
                '1.0.2',
            ],
            [
                'Apple Mac OS X v10.6.8 CoreMedia v1.0.4.10K540',
                '1.0.4',
            ],
            [
                'Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5',
                '0.0.0',
            ],
        ];
    }
}
