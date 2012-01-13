<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Os\Handlers;

/**
 * Copyright(c) 2011 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

use Browscap\Os\Handler as OsHandler;

/**
 * CatchAllUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

class Unknown extends OsHandler
{
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $userAgent
     * @return boolean always true
     */
    public function canHandle($userAgent)
    {
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('WordPress', 'TYPO3', 'bot', 'Bot', 'swarm', 'Nutch', 'python', 'cURL', '\\x', 'Feed Parser', 'Stream', 'Dillo', 'Index', '.exe', 'Spider', 'SPIDER', '000;', 'Cloud', 'client', 'Google', 'Netscape', '?>', 'www.', 'WebWasher'))) {
            return true;
        }
        
        return false;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detect($userAgent)
    {
        $class = new \StdClass();
        
        $class->name     = 'unknown';
        $class->osFull   = 'unknown';
        $class->version  = '';
        $class->bits     = 0;
        
        return $class;
    }
    
    public function getWeight()
    {
        return 0;
    }
}