<?php
namespace Browscap\Os\Handlers;

/**
 * Copyright (c) 2012 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

use Browscap\Os\Handler as OsHandler;

/**
 * MSIEAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class Linux extends OsHandler
{
    /**
     * @var string the detected platform
     */
    protected $_name = 'Linux';
    
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        if (!$this->_utils->checkIfContains(array('Linux', 'linux', 'X11'))) {
            return false;
        }
        
        $isNotReallyAnLinux = array(
            // special Linux versions
            'android',
            'debian',
            'ubuntu',
            'centos',
            'cros',
            'joli os',
            'mint',
            'suse',
            'fedora',
            'redhat',
            'red hat',
            'slackware',
            'nettv',
            'hbbtv',
            'hpwos',
            'smart-tv',
            // other OS which are using X11
            'bsd',
            'sunos',
            'hp-ux'
        );
        
        if ($this->_utils->checkIfContains($isNotReallyAnLinux, true)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $doMatch = preg_match('/Linux\/(\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/Linux (\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $this->_version = '';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 606;
    }
}