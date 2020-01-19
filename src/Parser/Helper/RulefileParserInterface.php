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
namespace BrowserDetector\Parser\Helper;

interface RulefileParserInterface
{
    /**
     * @param \SplFileInfo $file
     * @param string       $useragent
     * @param string       $fallback
     *
     * @return string
     */
    public function parseFile(\SplFileInfo $file, string $useragent, string $fallback): string;
}
