<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\GenericLoader;
use BrowserDetector\Loader\PlatformLoaderFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use UaResult\Os\Os;
use UaResult\Os\OsInterface;

class PlatformFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new PlatformFactory();
    }

    /**
     * @return void
     */
    public function testToArray(): void
    {
        self::markTestIncomplete();
    }
}
