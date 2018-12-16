<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Bits;

use Stringy\Stringy;

final class Browser implements BitsInterface
{
    /**
     * @var string the user agent to handle
     */
    private $useragent;

    /**
     * class constructor
     *
     * @param string $useragent
     */
    public function __construct(string $useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return int
     */
    public function getBits(): int
    {
        $s = new Stringy($this->useragent);

        // 32 bits on 64 bit system
        if ($s->containsAny(['i686 on x86_64', 'i686 (x86_64)'], false)) {
            return 32;
        }

        // 64 bits
        if ($s->containsAny(['x64', 'win64', 'x86_64', 'amd64', 'ppc64', 'sparc64', 'osf1'], false)) {
            return 64;
        }

        // old deprecated 16 bit windows systems
        if ($s->containsAny(['win3.1', 'windows 3.1'], false)) {
            return 16;
        }

        // old deprecated 8 bit systems
        if ($s->containsAny(['cp/m', '8-bit'], false)) {
            return 8;
        }

        return 32;
    }
}
