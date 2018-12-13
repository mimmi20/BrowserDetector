<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Helper;

use BrowserDetector\Helper;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class IosTest extends TestCase
{
    /**
     * @dataProvider providerIsiOS
     *
     * @param string $agent
     *
     * @return void
     */
    public function testIsiOS(string $agent): void
    {
        self::markTestIncomplete();
        $object = new Helper\Ios(new Stringy($agent));

        self::assertTrue($object->isIos());
    }

    /**
     * @return array[]
     */
    public function providerIsiOS(): array
    {
        return [
            ['AntennaPod/1.5.2.0'],
            ['Antenna/965 CFNetwork/758.2.8 Darwin/15.0.0'],
            ['RSS_Radio 1.5'],
            ['RSSRadio (Push Notification Scanner;support@dorada.co.uk)'],
            ['iTunes/10.5.2 (PodCruncher 2.2)'],
            ['https://audioboom.com/boos/'],
            ['Stitcher/iOS'],
            ['CaptiveNetworkSupport-324 wispr'],
            ['Mozilla/5.0 (iOS; U; en) AppleWebKit/533.19.4 (KHTML, like Gecko) AdobeAIR/13.0'],
            ['Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4'],
            ['Mozilla/5.0 (X11; U; Linux x86_64; ar-SA) AppleWebKit/534.35 (KHTML, like Gecko)  Chrome/11.0.696.65 Safari/534.35 Puffin/3.11546IP'],
            ['iOS/6.1.3 (10B329) dataaccessd/1.0'],
            ['Mozilla/5.0 (iPhone; CPU iPhone OS 8_0_2 like Mac OS X) (Windows NT 6.1; WOW64) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12A405 MicroMessenger/5.4.2 NetType/WIFI'],
            ['IUC(U;iOS 5.1.1;Zh-cn;320*480;)/UCWEB7.9.0.94/41/997'],
        ];
    }

    /**
     * @dataProvider providerIsNotiOS
     *
     * @param string $agent
     *
     * @return void
     */
    public function testIsNotiOS(string $agent): void
    {
        self::markTestIncomplete();
        $object = new Helper\Ios(new Stringy($agent));

        self::assertFalse($object->isIos());
    }

    /**
     * @return array[]
     */
    public function providerIsNotiOS(): array
    {
        return [
            ['Microsoft Office Excel 2013'],
            ['Mozilla/5.0 (X11; U; Linux Core i7-4980HQ; de; rv:32.0; compatible; Jobboerse.com; http://www.xn--jobbrse-d1a.com) Gecko/20100401 Firefox/24.0'],
            ['Mozilla/5.0 (compatible; MSIE or Firefox mutant; not on Windows server; + http://tab.search.daum.net/aboutWebSearch.html) Daumoa/3.0'],
            ['Mozilla/5.0 (Windows Phone 8.1; ARM; Trident/7.0; Touch; rv:11; IEMobile/11.0) like Android 4.1.2; compatible) like iPhone OS 7_0_3 Mac OS X WebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.99 Mobile Safari /537.36'],
            ['Mozilla/5.0 (Linux; U; Android 4.2.1; de-de; iphone Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'],
            ['Opera/9.80 (X11; Linux i686; Edition Linux Mint) Presto/2.12.388 Version/12.16'],
            ['Mozilla/5.0 (X11; U; Linux i686; pl-PL; rv:1.9.2a1pre) Gecko/20090330 Kubuntu/8.10 (intrepid) Minefield/3.2a1pre'],
            ['curl/7.15.5 (x86_64-redhat-linux-gnu) libcurl/7.15.5 OpenSSL/0.9.8b zlib/1.2.3 libidn/0.6.5'],
            ['OMozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.9) Gecko/20100827 Red Hat/3.6.9-2.el6 Firefox/3.6.9'],
            ['Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.8.0.5) Gecko/20060805 CentOS/1.0.3-0.el4.1.centos4 SeaMonkey/1.0.3'],
            ['Mozilla/5.0 (X11; CrOS x86_64 14.4.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2558.0 Safari/537.36'],
            ['Mozilla/5.0 (X11; Jolicloud Linux i686) AppleWebKit/537.6 (KHTML, like Gecko) Joli OS/1.2 Chromium/23.0.1240.0 Chrome/23.0.1240.0 Safari/537.6'],
            ['Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.0.7) Gecko/2009031120 Mandriva/1.9.0.7-0.1mdv2009.0 (2009.0) Firefox/3.0.7'],
            ['Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.0.14) Gecko/2009090900 SUSE/3.0.14-0.1 Firefox/3.0.14'],
            ['Mozilla/5.0 (X11; U; Linux i686; en; rv:1.9) Gecko/20080528 (Gentoo) Epiphany/2.22 Firefox/3.0'],
            ['Mozilla/5.0 (X11; Linux i686) AppleWebKit/534.30 (KHTML, like Gecko) Slackware/Chrome/12.0.742.100 Safari/534.30'],
            ['Mozilla/5.0 (Linux; U; Linux Ventana; de-de; Transformer TF101G Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/8.0 Safari/534.13'],
            ['Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.1.1) Gecko/20090725 Moblin/3.5.1-2.5.14.moblin2 Shiretoko/3.5.1'],
            ['QuickTime\\\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)'],
            ['Mozilla/5.0 (Linux; U; Android 4.1.1; de-de; TechniPad_10-3G Build/JRO03H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30'],
        ];
    }
}
