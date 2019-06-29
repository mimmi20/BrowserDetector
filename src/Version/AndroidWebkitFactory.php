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
namespace BrowserDetector\Version;

use BrowserDetector\Version\Helper\Safari as SafariHelper;
use Psr\Log\LoggerInterface;

final class AndroidWebkitFactory implements AndroidWebkitFactoryInterface
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Version\AndroidWebkit
     */
    public function __invoke(LoggerInterface $logger): AndroidWebkit
    {
        return new AndroidWebkit(
            $logger,
            new VersionFactory(),
            new SafariHelper()
        );
    }
}
