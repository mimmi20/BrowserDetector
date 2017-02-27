<?php


namespace BrowserDetector\Helper;

use Stringy\Stringy;

/**
 * a helper to detect windows
 */
class Ios
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * Class Constructor
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\Ios
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isIos()
    {
        if (false !== stripos($this->useragent, 'technipad')) {
            return false;
        }

        $s = new Stringy($this->useragent);

        if ($s->containsAny(['trident', 'windows phone', 'android'], false)) {
            return false;
        }

        if (preg_match('/(IphoneOSX|iPhone OS|like Mac OS X|iPad|IPad|iPhone|iPod|CPU OS|CPU iOS|IUC\(U;iOS|iOS;)/', $this->useragent)) {
            return true;
        }

        if (preg_match('/Puffin\/[\d\.]+I(P|T)/', $this->useragent)) {
            return true;
        }

        if ($s->containsAll(['windows nt', 'iphone', 'micromessenger'], false)) {
            return true;
        }

        $os = [
            'antenna/',
            'antennapod',
            'rss_radio',
            'rssradio',
            'podcruncher',
            'audioboom',
            'stitcher/ios',
            'captivenetwork',
            'dataaccessd',
        ];

        if (!$s->containsAny($os, false)) {
            return false;
        }

        return true;
    }
}
