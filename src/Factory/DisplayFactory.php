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
namespace BrowserDetector\Factory;

use Psr\Log\LoggerInterface;
use UaResult\Device\Display;
use UaResult\Device\DisplayInterface;

final class DisplayFactory implements DisplayFactoryInterface
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Device\DisplayInterface
     */
    public function fromArray(LoggerInterface $logger, array $data): DisplayInterface
    {
        assert(array_key_exists('width', $data), '"width" property is required');
        assert(array_key_exists('height', $data), '"height" property is required');
        assert(array_key_exists('touch', $data), '"touch" property is required');
        assert(array_key_exists('size', $data), '"size" property is required');

        $width  = $data['width'];
        $height = $data['height'];
        $touch  = $data['touch'];
        $size   = $data['size'];

        return new Display($width, $height, $touch, $size);
    }
}
