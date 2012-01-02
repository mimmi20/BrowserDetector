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

/**
 * Handler Base class
 */
use Browscap\Browser\Handler as BrowserHandler;

/**
 * Browser Exceptions
 */
use Browscap\Browser\Exceptions;

/**
 * MSIEAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class MicrosoftOutlook extends BrowserHandler
{
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfContains($userAgent, 'Outlook')
            && !$this->utils->checkIfContains($userAgent, 'Microsoft Office')
            && !$this->utils->checkIfContains($userAgent, 'MSOffice')
        ) {
            return false;
        }
        
        $isNotReallyAnIE = array(
            // using also the Trident rendering engine
            'Maxthon',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'Flock',
            'AOL',
            'TOB',
            'Avant',
            'MyIE',
            //others
            'AppleWebKit',
            'Chrome',
            'Linux',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            //Fakes
            'User agent',
            'User-Agent'
        );
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, $isNotReallyAnIE)) {
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
        return 'Microsoft Outlook';
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectVersion($userAgent)
    {
        $doMatch = preg_match('/Microsoft Office Outlook ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/Microsoft Outlook ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/MSOffice ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/Microsoft Office\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        return '';
    }
}