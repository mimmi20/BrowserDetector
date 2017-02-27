<?php


namespace BrowserDetector\Helper;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MicrosoftOffice
{
    /**
     * maps the version
     *
     * @param string $version
     *                        returns null, if the device does not have a specific Operating System, returns the OS Handler otherwise
     *
     * @return string
     */
    public function mapVersion($version)
    {
        if (15 === (int) $version) {
            return '2013';
        }

        if (14 === (int) $version) {
            return '2010';
        }

        if (12 === (int) $version) {
            return '2007';
        }

        return '0.0';
    }

    /**
     * detects the browser version from the given user agent
     *
     * @param string $useragent
     *
     * @return string
     */
    public function detectInternalVersion($useragent)
    {
        $doMatch = preg_match(
            '/MSOffice ([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match('/MSOffice (\d+)/', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match(
            '/microsoft Office\/([\d\.]+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match(
            '/microsoft Office\/(\d+)/',
            $useragent,
            $matches
        );

        if ($doMatch) {
            return $matches[1];
        }

        return '0.0';
    }
}
