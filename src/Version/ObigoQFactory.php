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
namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

final class ObigoQFactory implements ObigoQFactoryInterface
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Version\ObigoQ
     */
    public function __invoke(LoggerInterface $logger): ObigoQ
    {
        return new ObigoQ(
            $logger,
            new VersionFactory()
        );
    }
}
