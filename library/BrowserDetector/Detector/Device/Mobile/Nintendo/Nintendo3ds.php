<?php
namespace BrowserDetector\Detector\Device\Mobile\Nintendo;

/**
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be
 *   used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

use BrowserDetector\Detector\Browser\Mobile\NetFront;
use BrowserDetector\Detector\Browser\Mobile\Opera;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Chain;
use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\DeviceHandler;
use BrowserDetector\Detector\MatcherInterface;
use BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use BrowserDetector\Detector\Os\UnknownOs;
use BrowserDetector\Detector\Type\Device as DeviceType;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class Nintendo3ds
    extends DeviceHandler
    implements MatcherInterface, DeviceInterface
{
    /**
     * the detected browser properties
     *
     * @var array
     */
    protected $properties = array();

    /**
     * Class Constructor
     *
     * @return \BrowserDetector\Detector\Device\Mobile\Nintendo\Nintendo3ds
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties = array(
            'wurflKey'                => null, // not in wurfl

            // kind of device
            'device_type'             => new DeviceType\TvConsole(), // not in wurfl

            // device
            'model_name'              => '3DS',
            'model_version'           => null, // not in wurfl
            'manufacturer_name'       => new Company\Nintendo(),
            'brand_name'              => new Company\Nintendo(),
            'model_extra_info'        => null,
            'marketing_name'          => null,
            'has_qwerty_keyboard'     => true,
            'pointing_method'         => 'mouse',
            'device_bits'             => null, // not in wurfl
            'device_cpu'              => null, // not in wurfl

            // product info
            'can_assign_phone_number' => false,
            'ununiqueness_handler'    => null,
            'uaprof'                  => null,
            'uaprof2'                 => null,
            'uaprof3'                 => null,
            'unique'                  => true,

            // display
            'physical_screen_width'   => 400,
            'physical_screen_height'  => 400,
            'columns'                 => 120,
            'rows'                    => 200,
            'max_image_width'         => 650,
            'max_image_height'        => 600,
            'resolution_width'        => 685,
            'resolution_height'       => 600,
            'dual_orientation'        => false,
            'colors'                  => 65536,

            // sms
            'sms_enabled'             => true,

            // chips
            'nfc_support'             => true,
        );
    }

    /**
     * checks if this device is able to handle the useragent
     *
     * @return boolean returns TRUE, if this device can handle the useragent
     */
    public function canHandle()
    {
        if (!$this->utils->checkIfContains('Nintendo 3DS')) {
            return false;
        }

        return true;
    }

    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 3;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detectDevice()
    {
        return $this;
    }

    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\OsHandler
     */
    public function detectBrowser()
    {
        $browsers = array(
            new NetFront(),
            new Opera()
        );

        $chain = new Chain();
        $chain->setUserAgent($this->_useragent);
        $chain->setHandlers($browsers);
        $chain->setDefaultHandler(new UnknownBrowser());

        return $chain->detect();
    }

    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\BrowserDetector\Detector\OsHandler
     */
    public function detectOs()
    {
        $handler = new UnknownOs();
        $handler->setUseragent($this->_useragent);

        return $handler->detect();
    }
}