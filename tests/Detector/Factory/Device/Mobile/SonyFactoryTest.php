<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\SonyFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class SonyFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $deviceName
     * @param string $marketingName
     * @param string $manufacturer
     * @param string $brand
     * @param string $deviceType
     * @param bool   $dualOrientation
     * @param string $pointingMethod
     */
    public function testDetect($agent, $deviceName, $marketingName, $manufacturer, $brand, $deviceType, $dualOrientation, $pointingMethod)
    {
        /** @var \UaResult\Device\DeviceInterface $result */
        $result = SonyFactory::detect($agent);

        self::assertInstanceOf('\UaResult\Device\DeviceInterface', $result);

        self::assertSame(
            $deviceName,
            $result->getDeviceName(),
            'Expected device name to be "' . $deviceName . '" (was "' . $result->getDeviceName() . '")'
        );
        self::assertSame(
            $marketingName,
            $result->getMarketingName(),
            'Expected marketing name to be "' . $marketingName . '" (was "' . $result->getMarketingName() . '")'
        );
        self::assertSame(
            $manufacturer,
            $result->getManufacturer(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer() . '")'
        );
        self::assertSame(
            $brand,
            $result->getBrand(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrand() . '")'
        );
        self::assertSame(
            $deviceType,
            $result->getType()->getName(),
            'Expected device type to be "' . $deviceType . '" (was "' . $result->getType()->getName() . '")'
        );
        self::assertSame(
            $dualOrientation,
            $result->getDualOrientation(),
            'Expected dual orientation to be "' . $dualOrientation . '" (was "' . $result->getDualOrientation() . '")'
        );
        self::assertSame(
            $pointingMethod,
            $result->getPointingMethod(),
            'Expected pointing method to be "' . $pointingMethod . '" (was "' . $result->getPointingMethod() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'SonyEricssonCK15i/R3AE017 TelecaBrowser/Q07C1-1 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'CK15i',
                'CK15i',
                'SonyEricsson',
                'SonyEricsson',
                'Mobile Phone',
                null,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; MT27i Build/6.1.1.B.1.54) U2/1.0.0 UCBrowser/10.6.0.706 Mobile',
                'MT27i',
                'Xperia Sola',
                'SonyEricsson',
                'SonyEricsson',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3.1; de-de; Xperia T Build/JLS36I) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 CyanogenMod/10.2.0/mint',
                'LT30p',
                'Xperia T',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; en-us; EBRD1101; EXT) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'PRST1',
                'Reader Wi-Fi',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; LT18i) U2/1.0.0 UCBrowser/10.0.0.556 Mobile',
                'LT18i',
                'Xperia Arc',
                'SonyEricsson',
                'SonyEricsson',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'SonyEricssonWT13i/R3AF010 TelecaBrowser/Q07C1-1 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'WT13i',
                'WT13i',
                'SonyEricsson',
                'SonyEricsson',
                'Mobile Phone',
                null,
                null,
            ],
            [
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-US; D5803 Build/23.4.A.1.232) U2/1.0.0 UCBrowser/10.7.0.636 Mobile',
                'D5803',
                'Xperia Z3 Compact',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'SonyEricssonU10i/R7BA Browser/NetFront/3.5 Profile/MIDP-2.1 Configuration/CLDC-1.1 JavaPlatform/JP-8.5.2',
                'U10i',
                'Aino',
                'SonyEricsson',
                'SonyEricsson',
                'Mobile Phone',
                null,
                null,
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; ST18i) U2/1.0.0 UCBrowser/9.9.0.543 Mobile',
                'ST18i',
                'Urushi',
                'SonyEricsson',
                'SonyEricsson',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; L50u Build/17.1.1.F.0.43) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36 tieba/7.8.0',
                'L50u',
                'Xperia Z2 LTE',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; nl-nl; SonyLT26i Build/6.2.B.1.96) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'LT26i',
                'Xperia Arc HD',
                'SonyEricsson',
                'SonyEricsson',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; LT26w Build/6.2.B.1.96) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.58 Mobile Safari/537.31',
                'LT26w',
                'Xperia Acro S',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; ST26i Build/11.2.A.0.31) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.99 Mobile Safari/537.36',
                'ST26i',
                'Xperia J',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; D6603 Build/23.0.1.A.5.77) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/34.0.0.0 Mobile Safari/537.36',
                'D6603',
                'Xperia Z3',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.3; C5303 Build/12.1.A.1.205) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36',
                'C5303',
                'Xperia SP LTE',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Dalvik/1.6.0 (Linux; U; Android 4.3; LT30p Build/9.2.A.1.199)',
                'LT30p',
                'Xperia T',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Dalvik/1.6.0 (Linux; U; Android 4.3; C6903 Build/14.2.A.1.136)',
                'C6903',
                'Xperia Z1',
                'Sony',
                'Sony',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
