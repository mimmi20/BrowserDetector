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
namespace BrowserDetector\Factory;

use UaResult\Device\MarketInterface;

interface MarketFactoryInterface
{
    /**
     * @param array $data
     *
     * @return \UaResult\Device\MarketInterface
     */
    public function fromArray(array $data): MarketInterface;
}
