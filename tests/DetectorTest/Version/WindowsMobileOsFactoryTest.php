<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\WindowsMobileOs;
use BrowserDetector\Version\WindowsMobileOsFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

use function assert;
use function get_class;
use function sprintf;

final class WindowsMobileOsFactoryTest extends TestCase
{
    private WindowsMobileOsFactory $object;

    protected function setUp(): void
    {
        $this->object = new WindowsMobileOsFactory();
    }

    public function testInvoke(): void
    {
        $object = $this->object;
        assert($object instanceof WindowsMobileOsFactory, sprintf('$object should be an instance of %s, but is %s', WindowsMobileOsFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(WindowsMobileOs::class, $result);
    }
}
