<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Trident;
use BrowserDetector\Version\TridentFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class TridentFactoryTest extends TestCase
{
    /** @var \BrowserDetector\Version\TridentFactory */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new TridentFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        \assert($object instanceof TridentFactory, sprintf('$object should be an instance of %s, but is %s', TridentFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(Trident::class, $result);
    }
}
