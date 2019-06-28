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

use BrowserDetector\Version\Safari;
use BrowserDetector\Version\SafariFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class SafariFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\SafariFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new SafariFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        /** @var SafariFactory $object */
        $object = $this->object;
        $result = $object(new NullLogger());
        static::assertInstanceOf(Safari::class, $result);
    }
}
