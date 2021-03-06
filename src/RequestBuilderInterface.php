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

namespace BrowserDetector;

use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use UaRequest\GenericRequest;
use UnexpectedValueException;

interface RequestBuilderInterface
{
    /**
     * @param array<string, string>|GenericRequest|MessageInterface|string $request
     *
     * @throws UnexpectedValueException
     */
    public function buildRequest(LoggerInterface $logger, $request): GenericRequest;
}
