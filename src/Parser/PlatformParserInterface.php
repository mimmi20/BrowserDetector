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

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\NotFoundException;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

interface PlatformParserInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): OsInterface;

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): OsInterface;
}
