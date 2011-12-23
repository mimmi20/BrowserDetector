<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Handlers;

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

use Browscap\Browser\Handler as BrowserHandler;

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

class Googlebot extends BrowserHandler
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
        if (!$this->utils->checkIfStartsWith($userAgent, 'Google')) {
            return false;
        }
        
        if (!$this->utils->checkIfContainsAnyOf($userAgent, array('Googlebot'))) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectBrowser($userAgent)
    {
        return 'Googlebot';
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $userAgent
     *
     * @return float
     */
    protected function detectVersion($userAgent)
    {
        $doMatch = preg_match('/Googlebot\/([\d\.]+) /', $userAgent, $matches);
        
        if ($doMatch) {
            return (float) $matches[1];
        }
        
        $doMatch = preg_match('/Googlebot v([\d\.]+) /', $userAgent, $matches);
        
        if ($doMatch) {
            return (float) $matches[1];
        }
        
        $doMatch = preg_match('/Googlebot-Image\/([\d\.]+) /', $userAgent, $matches);
        
        if ($doMatch) {
            return (float) $matches[1];
        }
        
        $doMatch = preg_match('/Googlebot-News\/([\d\.]+) /', $userAgent, $matches);
        
        if ($doMatch) {
            return (float) $matches[1];
        }
        
        $doMatch = preg_match('/Google\/([\d\.]+) /', $userAgent, $matches);
        
        if ($doMatch) {
            return (float) $matches[1];
        }
        
        return 0;
    }
}