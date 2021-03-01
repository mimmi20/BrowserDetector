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
namespace BrowserDetector\Loader\Helper;

interface FilterInterface
{
    /**
     * @param string $path
     * @param string $extension
     *
     * @return \Iterator
     */
    public function __invoke(string $path, string $extension): \Iterator;
}
