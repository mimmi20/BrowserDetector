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

namespace BrowserDetectorTest\Bits;

use BrowserDetector\Bits\Browser;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class BrowserTest extends TestCase
{
    private Browser $object;

    protected function setUp(): void
    {
        $this->object = new Browser();
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     *
     * @dataProvider providerGetBits
     */
    public function testGetBits(string $useragent, ?int $expected): void
    {
        $result = $this->object->getBits($useragent);
        self::assertSame($expected, $result);

        $secondResult = $this->object->getBits($useragent);
        self::assertSame($expected, $secondResult);
        self::assertSame($result, $secondResult);
    }

    /**
     * @return array<int, array<string, int|string|null>>
     */
    public function providerGetBits(): array
    {
        return [
            [
                'ua' => 'Mozilla/5.0 (X11; Linux i686 on x86_64; rv:38.0) Gecko/20100101 Firefox/38.0 Iceweasel/38.5.0',
                'expected' => 32,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux x86_64; C) AppleWebKit/533.3 (KHTML, like Gecko) Qt/4.7.1 Safari/533.3',
                'expected' => 64,
            ],
            [
                'ua' => 'Mozilla/2.0 (Compatible; MSIE 3.02; AOL 4.0; Windows 3.1)',
                'expected' => 16,
            ],
            [
                'ua' => 'ShitScript/1.0 (CP/M; 8-bit)',
                'expected' => 8,
            ],
            [
                'ua' => 'Mozilla/5.0 Galeon/1.2.6 (X11; Linux i686; U;) Gecko/20020830',
                'expected' => null,
            ],
            [
                'ua' => 'Mozilla/5.0 (X11; U; Linux i686 (x86_64); en-US; rv:1.9.2.19) Gecko WebThumb/1.0',
                'expected' => 32,
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; arm_64; Android 9; I4213) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 YaBrowser/19.7.5.90.00 Mobile Safari/537.36',
                'expected' => 64,
            ],
        ];
    }
}
