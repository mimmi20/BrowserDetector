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

use BrowserDetector\Version\MicrosoftInternetExplorer;
use BrowserDetector\Version\MicrosoftInternetExplorerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class MicrosoftInternetExplorerFactoryTest extends TestCase
{
    /** @var \BrowserDetector\Version\MicrosoftInternetExplorerFactory */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new MicrosoftInternetExplorerFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        \assert($object instanceof MicrosoftInternetExplorerFactory, sprintf('$object should be an instance of %s, but is %s', MicrosoftInternetExplorerFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(MicrosoftInternetExplorer::class, $result);
    }
}
