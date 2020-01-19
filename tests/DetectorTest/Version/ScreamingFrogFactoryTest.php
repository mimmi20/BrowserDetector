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

use BrowserDetector\Version\ScreamingFrog;
use BrowserDetector\Version\ScreamingFrogFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class ScreamingFrogFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\ScreamingFrogFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new ScreamingFrogFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        /** @var ScreamingFrogFactory $object */
        $object = $this->object;
        $result = $object(new NullLogger());
        self::assertInstanceOf(ScreamingFrog::class, $result);
    }
}
