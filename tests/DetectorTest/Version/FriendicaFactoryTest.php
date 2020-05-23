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

use BrowserDetector\Version\Friendica;
use BrowserDetector\Version\FriendicaFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class FriendicaFactoryTest extends TestCase
{
    /** @var \BrowserDetector\Version\FriendicaFactory */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new FriendicaFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        \assert($object instanceof FriendicaFactory, sprintf('$object should be an instance of %s, but is %s', FriendicaFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(Friendica::class, $result);
    }
}
