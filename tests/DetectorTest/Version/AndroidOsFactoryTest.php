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

use BrowserDetector\Version\AndroidOs;
use BrowserDetector\Version\AndroidOsFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class AndroidOsFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\AndroidOsFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new AndroidOsFactory();
    }

    public function testInvoke(): void
    {
        /** @var AndroidOsFactory $object */
        $object = $this->object;
        $result = $object(new NullLogger());
        static::assertInstanceOf(AndroidOs::class, $result);
    }
}
