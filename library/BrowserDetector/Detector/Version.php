<?php
namespace BrowserDetector\Detector;

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

/**
 * a general version detector
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
class Version implements \Serializable
{
    /**
     * @var integer
     */
    const MAJORONLY = 1;

    /**
     * @var integer
     */
    const MINORONLY = 2;

    /**
     * @var integer
     */
    const MAJORMINOR = 3;

    /**
     * @var integer
     */
    const MINORMICRO = 6;

    /**
     * @var integer
     */
    const MICROONLY = 4;

    /**
     * @var integer
     */
    const COMPLETE = 7;

    /**
     * @var integer
     */
    const IGNORE_NONE = 0;

    /**
     * @var integer
     */
    const IGNORE_MINOR = 8;

    /**
     * @var integer
     */
    const IGNORE_MICRO = 16;

    /**
     * @var integer
     */
    const IGNORE_MINOR_IF_EMPTY = 32;

    /**
     * @var integer
     */
    const IGNORE_MICRO_IF_EMPTY = 64;

    /**
     * @var integer
     */
    const IGNORE_MACRO_IF_EMPTY = 128;

    /**
     * @var integer
     */
    const COMPLETE_IGNORE_EMPTY = 231;

    /**
     * @var integer
     */
    const GET_ZERO_IF_EMPTY = 256;

    /**
     * @var string the user agent to handle
     */
    private $_useragent = null;

    /**
     * @var string the detected complete version
     */
    private $_version = null;

    /**
     * @var string the detected major version
     */
    private $_major = null;

    /**
     * @var string the detected minor version
     */
    private $_minor = null;

    /**
     * @var string the detected micro version
     */
    private $_micro = null;

    /**
     * @var string the default version
     */
    private $_default = '';

    /**
     * @var integer
     */
    private $_mode = self::COMPLETE;

    /**
     * serializes the object
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(
            array(
                'version'   => $this->_version,
                'mode'      => $this->_mode,
                'useragent' => $this->_useragent,
                'default'   => $this->_default
            )
        );
    }

    /**
     * unserializes the object
     *
     * @param string $data The serialized data
     */
    public function unserialize($data)
    {
        $unseriliazedData = unserialize($data);

        $this->_version   = $unseriliazedData['version'];
        $this->_mode      = $unseriliazedData['mode'];
        $this->_useragent = $unseriliazedData['useragent'];
        $this->_default   = $unseriliazedData['default'];

        $this->setVersion($this->_version);
    }

    /**
     * magic function needed to reconstruct the class from a var_export
     *
     * @param array $array
     *
     * @return Version
     */
    static function __set_state(array $array)
    {
        $obj = new self;

        foreach ($array as $k => $v) {
            $obj->$k = $v;
        }

        return $obj;
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $userAgent
     *
     * @return Version
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;

        return $this;
    }

    /**
     * sets the user agent to be handled
     *
     * @param integer $mode
     *
     * @return Version
     */
    public function setMode($mode)
    {
        $this->_mode = $mode;

        return $this;
    }

    /**
     * returns the detected version
     *
     * @param integer $mode
     *
     * @return string
     * @throws \UnexpectedValueException
     */
    public function getVersion($mode = null)
    {
        if (null === $this->_version) {
            if (null === $this->_useragent) {
                throw new \UnexpectedValueException(
                    'You have to set the useragent before calling this function'
                );
            }

            $this->detectVersion();
        } elseif (null === $this->_major) {
            $this->setVersion($this->_version);
        }

        if (null === $mode) {
            $mode = $this->_mode;
        }

        $versions = array();
        if (self::MAJORONLY & $mode) {
            $versions[0] = $this->_major;
        }

        if (self::MINORONLY & $mode) {
            $versions[1] = $this->_minor;
        }

        if (self::MICROONLY & $mode) {
            $versions[2] = $this->_micro;
        }

        $microIsEmpty = false;
        if (empty($versions[2])
            || '0' === $versions[2]
            || '' === $versions[2]
        ) {
            $microIsEmpty = true;
        }

        if (self::IGNORE_MICRO & $mode) {
            unset($versions[2]);
        } elseif (self::IGNORE_MICRO_IF_EMPTY & $mode
            && $microIsEmpty
        ) {
            unset($versions[2]);
        }

        $minorIsEmpty = false;

        if (self::IGNORE_MINOR & $mode) {
            unset($versions[1]);
            unset($versions[2]);
            $minorIsEmpty = true;
        } elseif (self::IGNORE_MINOR_IF_EMPTY & $mode) {
            if ((empty($versions[1])
                || '0' === $versions[1]
                || '00' === $versions[1]
                || '' === $versions[1])
                && $microIsEmpty
            ) {
                $minorIsEmpty = true;
            }

            if ($minorIsEmpty) {
                unset($versions[1]);
                unset($versions[2]);
            }
        }

        $macroIsEmpty = false;

        if (self::IGNORE_MACRO_IF_EMPTY & $mode) {
            if ((empty($versions[0])
                || '0' === $versions[0]
                || '' === $versions[0])
                && $minorIsEmpty
            ) {
                $macroIsEmpty = true;
            }

            if ($macroIsEmpty) {
                unset($versions[0]);
                unset($versions[1]);
                unset($versions[2]);
            }
        }

        $version = implode('.', $versions);

        if ('0' === $version || '0.0' === $version || '0.0.0' === $version) {
            $version = '';
        }

        if (self::GET_ZERO_IF_EMPTY & $mode && '' === $version) {
            $version = '0';
        }

        return $version;
    }

    /**
     * detects the bit count by this browser from the given user agent
     *
     * @param string|array $searches
     *
     * @return Version
     * @throws \UnexpectedValueException
     */
    public function detectVersion($searches = null)
    {
        if (!is_array($searches) && !is_string($searches)) {
            throw new \UnexpectedValueException(
                'a string or an array of strings is expected as parameter'
            );
        }

        if (!is_array($searches)) {
            $searches = array($searches);
        }

        $modifiers = array(
            array('\/', ''),
            array('\(', '\)'),
            array(' ', ''),
            array('', ''),
            array(' \(', '\;')
        );

        $version = $this->_default;
        $found   = false;

        $useragent = $this->_useragent;

        if (false !== strpos($useragent, '%')) {
            $useragent = urldecode($useragent);
        }

        foreach ($searches as $search) {
            if (!is_string($search)) {
                continue;
            }

            if (false !== strpos($search, '%')) {
                $search = urldecode($search);
            }

            $found = false;

            foreach ($modifiers as $modifier) {
                $compareString = '/' . $search . $modifier[0] . '(\d+[\d\.\_ab]+)'
                    . $modifier[1] . '/';

                $doMatch = preg_match(
                    $compareString, $useragent, $matches
                );

                if ($doMatch) {
                    $version = $matches[1];
                    $found   = true;
                    break;
                }
            }

            if ($found) {
                break;
            }
        }

        return $this->setVersion($version);
    }

    /**
     * sets the detected version
     *
     * @param string $version
     *
     * @return Version
     * @throws \UnexpectedValueException
     */
    public function setVersion($version)
    {
        $version  = trim(trim(str_replace('_', '.', $version)), '.');
        $splitted = explode('.', $version, 3);

        $this->_major = (!empty($splitted[0]) ? $splitted[0] : '0');
        $this->_minor = (!empty($splitted[1]) ? $splitted[1] : '0');
        $this->_micro = (!empty($splitted[2]) ? $splitted[2] : '0');

        $this->_version = $version;

        return $this;
    }

    /**
     * sets the default version, which is used, if no version could be detected
     *
     * @param string $version
     *
     * @return Version
     * @throws \UnexpectedValueException
     */
    public function setDefaulVersion($version)
    {
        if (!is_string($version)) {
            throw new \UnexpectedValueException(
                'the default version needs to be a string'
            );
        }

        $this->_default = $version;
    }

    public function __toString()
    {
        try {
            return $this->getVersion(
                Version::COMPLETE
            );
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * detects if the version is makred as Alpha
     *
     * @return boolean
     */
    public function isAlpha()
    {
        return (false !== strpos($this->_version, 'a'));
    }

    /**
     * detects if the version is makred as Beta
     *
     * @return boolean
     */
    public function isBeta()
    {
        return (false !== strpos($this->_version, 'b'));
    }
}