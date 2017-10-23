<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class MobileFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s): array
    {
        $factoriesBeforeSamsung = [
            'hiphone'     => Mobile\HiPhoneFactory::class,
            'v919 3g air' => Mobile\OndaFactory::class,
            'technisat'   => Mobile\TechnisatFactory::class,
            'technipad'   => Mobile\TechnisatFactory::class,
            'aqipad'      => Mobile\TechnisatFactory::class,
            'techniphone' => Mobile\TechnisatFactory::class,
            'navipad'     => Mobile\TexetFactory::class,
            'medipad'     => Mobile\BewatecFactory::class,
            'mipad'       => Mobile\XiaomiFactory::class,
            'nokia'       => Mobile\NokiaFactory::class,
        ];

        foreach ($factoriesBeforeSamsung as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->containsAll(['iphone', 'android'], false)
            && !$s->containsAny(['windows phone', 'iphone; cpu iphone os'], false)
        ) {
            return (new Mobile\XiangheFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAll(['iphone', 'adr', 'ucweb'], false)) {
            return (new Mobile\XiangheFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeApple = [
            'samsung'    => Mobile\SamsungFactory::class,
            'blackberry' => Mobile\BlackBerryFactory::class,
        ];

        foreach ($factoriesBeforeApple as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->containsAny(['ipad', 'ipod', 'iphone', 'like mac os x', 'darwin', 'cfnetwork'], false)
            && !$s->containsAny(['windows phone', ' adr ', 'ipodder', 'tripadvisor'], false)
        ) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeLg = [
            'asus'        => Mobile\AsusFactory::class,
            'mt-gt-a9500' => Mobile\HtmFactory::class,
            'gt-a7100'    => Mobile\SprdFactory::class,
            'feiteng'     => Mobile\FeitengFactory::class,
            'gt-h'        => Mobile\FeitengFactory::class,
            'cube'        => Mobile\CubeFactory::class,
            'u30gt'       => Mobile\CubeFactory::class,
            'u51gt'       => Mobile\CubeFactory::class,
            'u55gt'       => Mobile\CubeFactory::class,
            'i15-tcl'     => Mobile\CubeFactory::class,
            'u25gt-c4w'   => Mobile\CubeFactory::class,
            'gtx75'       => Mobile\UtStarcomFactory::class,
            'gt-9000'     => Mobile\StarFactory::class,
        ];

        foreach ($factoriesBeforeLg as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('LG', true)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum)\-/i', $useragent)) {
            return (new Mobile\SamsungFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeHtc = [
            'hdc'           => Mobile\HdcFactory::class,
            'galaxy s3 ex'  => Mobile\HdcFactory::class,
            'nexus 5'       => Mobile\LgFactory::class,
            'nexus 4'       => Mobile\LgFactory::class,
            'nexus5'        => Mobile\LgFactory::class,
            'nexus4'        => Mobile\LgFactory::class,
            'nexus 7'       => Mobile\AsusFactory::class,
            'nexus_7'       => Mobile\AsusFactory::class,
            'nexus7'        => Mobile\AsusFactory::class,
            'nexus 6p'      => Mobile\HuaweiFactory::class,
            'nexus 6'       => Mobile\MotorolaFactory::class,
            'nexus one'     => Mobile\HtcFactory::class,
            'nexus 9'       => Mobile\HtcFactory::class,
            'nexus evohd2'  => Mobile\HtcFactory::class,
            'nexushd2'      => Mobile\HtcFactory::class,
            'pantech'       => Mobile\PantechFactory::class,
            'hp'            => Mobile\HpFactory::class,
            'p160u'         => Mobile\HpFactory::class,
            'touchpad'      => Mobile\HpFactory::class,
            'pixi'          => Mobile\HpFactory::class,
            'palm'          => Mobile\HpFactory::class,
            'cm_tenderloin' => Mobile\HpFactory::class,
            'slate'         => Mobile\HpFactory::class,
            'galaxy' => Mobile\SamsungFactory::class,
            'nexus' => Mobile\SamsungFactory::class,
            'i7110' => Mobile\SamsungFactory::class,
            'i9100' => Mobile\SamsungFactory::class,
            'i9300' => Mobile\SamsungFactory::class,
            'yp-g' => Mobile\SamsungFactory::class,
            'blaze' => Mobile\SamsungFactory::class,
            's8500' => Mobile\SamsungFactory::class,
            'sony' => Mobile\SonyFactory::class,
            'accent' => Mobile\AccentFactory::class,
        ];

        foreach ($factoriesBeforeHtc as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('CCE', true)) {
            return (new Mobile\CceFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('htc', false) && !$s->contains('wohtc', false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeOnda = [
            'smarttab10' => Mobile\ZteFactory::class,
            'smarttab7' => Mobile\ZteFactory::class,
            'smart 4g' => Mobile\ZteFactory::class,
            'smart ultra 6' => Mobile\ZteFactory::class,
            'lenovo' => Mobile\LenovoFactory::class,
            'ideatab' => Mobile\LenovoFactory::class,
            'ideapad' => Mobile\LenovoFactory::class,
            'smarttab' => Mobile\LenovoFactory::class,
            'thinkpad' => Mobile\LenovoFactory::class,
            'startrail4' => Mobile\SfrFactory::class,
            'zte' => Mobile\ZteFactory::class,
            'racer' => Mobile\ZteFactory::class,
            'acer' => Mobile\AcerFactory::class,
            'iconia' => Mobile\AcerFactory::class,
            'liquid' => Mobile\AcerFactory::class,
            'playstation' => Mobile\SonyFactory::class,
            'amazon' => Mobile\AmazonFactory::class,
            'kindle' => Mobile\AmazonFactory::class,
            'silk' => Mobile\AmazonFactory::class,
            'kftt' => Mobile\AmazonFactory::class,
            'kfot' => Mobile\AmazonFactory::class,
            'kfjwi' => Mobile\AmazonFactory::class,
            'kfsowi' => Mobile\AmazonFactory::class,
            'kfthwi' => Mobile\AmazonFactory::class,
            'sd4930ur' => Mobile\AmazonFactory::class,
            'kfapwa' => Mobile\AmazonFactory::class,
            'kfaswi' => Mobile\AmazonFactory::class,
            'kfapwi' => Mobile\AmazonFactory::class,
            'kfdowi' => Mobile\AmazonFactory::class,
            'kfauwi' => Mobile\AmazonFactory::class,
            'kfgiwi' => Mobile\AmazonFactory::class,
            'kftbwi' => Mobile\AmazonFactory::class,
            'kfmewi' => Mobile\AmazonFactory::class,
            'kffowi' => Mobile\AmazonFactory::class,
            'kfsawi' => Mobile\AmazonFactory::class,
            'kfsawa' => Mobile\AmazonFactory::class,
            'kfarwi' => Mobile\AmazonFactory::class,
            'kfthwa' => Mobile\AmazonFactory::class,
            'kfjwa' => Mobile\AmazonFactory::class,
            'fire2' => Mobile\AmazonFactory::class,
            'amoi' => Mobile\AmoiFactory::class,
            'blaupunkt' => Mobile\BlaupunktFactory::class,
            'endeavour' => Mobile\BlaupunktFactory::class,
        ];

        foreach ($factoriesBeforeOnda as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('ONDA', true)) {
            return (new Mobile\OndaFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeCaterpillar = [
            'archos' => Mobile\ArchosFactory::class,
            'irulu' => Mobile\IruluFactory::class,
            'spice' => Mobile\SpiceFactory::class,
            'symphony' => Mobile\SymphonyFactory::class,
            'arnova' => Mobile\ArnovaFactory::class,
            ' bn ' => Mobile\BarnesNobleFactory::class,
            'bntv600' => Mobile\BarnesNobleFactory::class,
            'playbook' => Mobile\BlackBerryFactory::class,
            'rim tablet' => Mobile\BlackBerryFactory::class,
            'bb10' => Mobile\BlackBerryFactory::class,
            'stv100' => Mobile\BlackBerryFactory::class,
            'bba100-2' => Mobile\BlackBerryFactory::class,
            'bbb100-2' => Mobile\BlackBerryFactory::class,
        ];

        foreach ($factoriesBeforeCaterpillar as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('B15', true)) {
            return (new Mobile\CaterpillarFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeCoby = [
            'catnova' => Mobile\CatSoundFactory::class,
            'cat nova' => Mobile\CatSoundFactory::class,
            'cat stargate' => Mobile\CatSoundFactory::class,
            'cat tablet' => Mobile\CatSoundFactory::class,
            'cathelix' => Mobile\CatSoundFactory::class,
            'coby' => Mobile\CobyFactory::class,
            'nbpc724' => Mobile\CobyFactory::class,
        ];

        foreach ($factoriesBeforeCoby as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if (preg_match('/MID\d{4}/', $useragent)) {
            return (new Mobile\CobyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/WM\d{4}/', $useragent)) {
            return (new Mobile\WonderMediaFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeNec = [
            'comag' => Mobile\ComagFactory::class,
            'wtdr1018' => Mobile\ComagFactory::class,
            'coolpad' => Mobile\CoolpadFactory::class,
            'cosmote' => Mobile\CosmoteFactory::class,
            'creative' => Mobile\CreativeFactory::class,
            'ziilabs' => Mobile\CreativeFactory::class,
            'ziio7' => Mobile\CreativeFactory::class,
            'cubot' => Mobile\CubotFactory::class,
            'dell' => Mobile\DellFactory::class,
            'denver' => Mobile\DenverFactory::class,
            'tad-' => Mobile\DenverFactory::class,
            'taq-' => Mobile\DenverFactory::class,
            'connect7pro' => Mobile\OdysFactory::class,
            'connect8plus' => Mobile\OdysFactory::class,
            'sharp' => Mobile\SharpFactory::class,
        ];

        foreach ($factoriesBeforeNec as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('nec', false) && !$s->contains('fennec', false)) {
            return (new Mobile\NecFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/\d{3}SH/', $useragent)) {
            return (new Mobile\SharpFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SH\-?\d{2,4}(C|D|F|U)/', $useragent)) {
            return (new Mobile\SharpFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeEfox = [
            'n-06e' => Mobile\NecFactory::class,
            'n905i' => Mobile\NecFactory::class,
            'n705i' => Mobile\NecFactory::class,
            'docomo' => Mobile\DoCoMoFactory::class,
            'p900i' => Mobile\DoCoMoFactory::class,
            'easypix' => Mobile\EasypixFactory::class,
            'easypad' => Mobile\EasypixFactory::class,
            'junior 4.0' => Mobile\EasypixFactory::class,
        ];

        foreach ($factoriesBeforeEfox as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->containsAny(['Efox', 'SMART-E5'], true)) {
            return (new Mobile\EfoxFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeEfox = [
            'xoro' => Mobile\XoroFactory::class,
            'telepad' => Mobile\XoroFactory::class,
        ];

        foreach ($factoriesBeforeEfox as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->containsAny(['memup', 'slidepad'], false)) {
            return (new Mobile\MemupFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['epad', 'p7901a'], false)) {
            return (new Mobile\ZenithinkFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('p7mini', false)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('flytouch', false)) {
            return (new Mobile\FlytouchFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['fujitsu', 'm532', 'm305'], false)) {
            return (new Mobile\FujitsuFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['sn10t1'], false)) {
            return (new Mobile\HannspreeFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/hsg\d{4}/i', $useragent)) {
            return (new Mobile\HannspreeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('DA241HL', true)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SHL25', true)) {
            return (new Mobile\SharpFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/thl/i', $useragent) && !preg_match('/LIAuthLibrary/', $useragent)) {
            return (new Mobile\ThlFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Honlin', 'PC1088', 'HL'], true)) {
            return (new Mobile\HonlinFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('huawei', false)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('micromax', false)) {
            return (new Mobile\MicromaxFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SXZ', true)) {
            return (new Mobile\SxzFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('explay', false)) {
            return (new Mobile\ExplayFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('oneplus', false)) {
            return (new Mobile\OneplusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kingzone', false)) {
            return (new Mobile\KingzoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('goophone', false)) {
            return (new Mobile\GooPhoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('g-tide', false)) {
            return (new Mobile\GtideFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['turbopad', 'turbo pad'], false)) {
            return (new Mobile\TurboPadFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('haier', false)) {
            return (new Mobile\HaierFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AOC', true)) {
            return (new Mobile\AocFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('hummer', false)) {
            return (new Mobile\HummerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('oysters', false)) {
            return (new Mobile\OystersFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gfive', false)) {
            return (new Mobile\GfiveFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('iconbit', false)) {
            return (new Mobile\IconBitFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/INM\d{3,4}/', $useragent)) {
            return (new Mobile\IntensoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('jay-tech', false)) {
            return (new Mobile\JaytechFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['jolla', 'sailfish'], false)) {
            return (new Mobile\JollaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kazam', false)) {
            return (new Mobile\KazamFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kddi', false)) {
            return (new Mobile\KddiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kobo', false)) {
            return (new Mobile\KoboFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lenco', false)) {
            return (new Mobile\LencoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('LePan', true)) {
            return (new Mobile\LePanFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['LogicPD', 'Zoom2', 'NookColor', 'Nook Color'], true)) {
            return (new Mobile\LogicpdFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['medion', 'lifetab'], false)) {
            return (new Mobile\MedionFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('meizu', false)) {
            return (new Mobile\MeizuFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('hisense', false)) {
            return (new Mobile\HisenseFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('minix', false)) {
            return (new Mobile\MinixFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('allwinner', false)) {
            return (new Mobile\AllWinnerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('supra', false)) {
            return (new Mobile\SupraFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('prestigio', false)) {
            return (new Mobile\PrestigioFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/MI (\d|PAD|MAX|NOTE)/', $useragent)) {
            return (new Mobile\XiaomiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/HM( |\_)(NOTE|1SC|1SW|1S)/', $useragent)) {
            return (new Mobile\XiaomiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['mobistel', 'cynus'], false)) {
            return (new Mobile\MobistelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('moto', false)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('WeTab', true)) {
            return (new Mobile\NeofonieFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nintendo', false)) {
            return (new Mobile\NintendoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('odys', false)) {
            return (new Mobile\OdysFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('oppo', false)) {
            return (new Mobile\OppoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('panasonic', false)) {
            return (new Mobile\PanasonicFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pandigital', false)) {
            return (new Mobile\PandigitalFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('phicomm', false)) {
            return (new Mobile\PhicommFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pomp', false)) {
            return (new Mobile\PompFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('qmobile', false)) {
            return (new Mobile\QmobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sanyo', false)) {
            return (new Mobile\SanyoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('siemens', false)) {
            return (new Mobile\SiemensFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SIE-', true)) {
            return (new Mobile\SiemensFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sprint', false)) {
            return (new Mobile\SprintFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('intex', false)) {
            return (new Mobile\IntexFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('CAL21', true)) {
            return (new Mobile\CasioFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/XT\d{3,4}/', $useragent)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('g3mini', false)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(A|C)\d{5}/', $useragent)) {
            return (new Mobile\NomiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/one e\d{4}/i', $useragent)) {
            return (new Mobile\OneplusFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/one a200(1|3|5)/i', $useragent)) {
            return (new Mobile\OneplusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('HS-', true)) {
            return (new Mobile\HisenseFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['f5281', 'u972'], false)) {
            return (new Mobile\HisenseFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MOT', true)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TBD\d{4}/', $useragent)) {
            return (new Mobile\ZekiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TBD(B|C|G)\d{3,4}/', $useragent)) {
            return (new Mobile\ZekiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(AC0732C|RC9724C|MT0739D|QS0716D|LC0720C|MT0812E)/', $useragent)) {
            return (new Mobile\TriQFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ImPAD6213M_v2', true)) {
            return (new Mobile\ImpressionFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('S4503Q', true)) {
            return (new Mobile\DnsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dns', false)) {
            return (new Mobile\DnsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('D6000', true)) {
            return (new Mobile\InnosFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(S|V)T\d{5}/', $useragent)) {
            return (new Mobile\TrekStorFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kyocera', false)) {
            return (new Mobile\KyoceraFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('C6730', false)) {
            return (new Mobile\KyoceraFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['p4501', 'p850x', 'e4004', 'e691x', 'p1050x', 'p1032x', 'p1040x', 's1035x', 'p1035x', 'p4502', 'p851x'], false)) {
            return (new Mobile\MedionFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['g6600'], false)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/DG\d{3,4}/', $useragent)) {
            return (new Mobile\DoogeeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Touchlet', 'X7G', 'X10.'], true)) {
            return (new Mobile\PearlFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/mpqc\d{3,4}/i', $useragent)) {
            return (new Mobile\MpmanFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['terra pad', 'pad1002'], false)) {
            return (new Mobile\WortmannFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(C|D|E|F|G)\d{4}/', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/PM\-\d{4}/', $useragent)) {
            return (new Mobile\SanyoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['aqua_star', 'aqua star', 'aqua trend'], false)) {
            return (new Mobile\IntexFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('texet', false)) {
            return (new Mobile\TexetFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('s-tell', false)) {
            return (new Mobile\StellFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('bliss', false)) {
            return (new Mobile\BlissFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('alcatel', false)) {
            return (new Mobile\AlcatelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SPV', true)) {
            return (new Mobile\SpvFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('t-mobile', false)) {
            return (new Mobile\TmobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tolino', false)) {
            return (new Mobile\TolinoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('toshiba', false)) {
            return (new Mobile\ToshibaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('trekstor', false)) {
            return (new Mobile\TrekStorFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('3Q', true)) {
            return (new Mobile\TriQFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['viewsonic', 'viewpad'], false)) {
            return (new Mobile\ViewSonicFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('wiko', false)) {
            return (new Mobile\WikoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('VIVO IV', true)) {
            return (new Mobile\BluFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vivo', false)) {
            return (new Mobile\VivoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('haipai', false)) {
            return (new Mobile\HaipaiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('megafon', false)) {
            return (new Mobile\MegaFonFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('UMI', true)) {
            return (new Mobile\UmiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('yuanda', false)) {
            return (new Mobile\YuandaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Fly/', $useragent) && !preg_match('/FlyFlow/', $useragent)) {
            return (new Mobile\FlyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pocketbook', false)) {
            return (new Mobile\PocketBookFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('goclever', false)) {
            return (new Mobile\GoCleverFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('senseit', false)) {
            return (new Mobile\SenseitFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('twz', false)) {
            return (new Mobile\TwzFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('i-mobile', false)) {
            return (new Mobile\ImobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('evercoss', false)) {
            return (new Mobile\EvercossFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NGM', true)) {
            return (new Mobile\NgmFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dino', false)) {
            return (new Mobile\DinoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['shaan', 'iball'], false)) {
            return (new Mobile\ShaanFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/bmobile/i', $useragent) && !preg_match('/icabmobile/i', $useragent)) {
            return (new Mobile\BmobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('modecom', false)) {
            return (new Mobile\ModecomFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kiano', false)) {
            return (new Mobile\KianoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('philips', false)) {
            return (new Mobile\PhilipsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NTT', true)) {
            return (new Mobile\NttSystemFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pentagram', false)) {
            return (new Mobile\PentagramFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gigaset', false)) {
            return (new Mobile\GigasetFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('smartfren', false)) {
            return (new Mobile\SmartfrenFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Z221', 'V788D', 'KIS PLUS', 'N918St', 'Beeline Pro', 'ATLAS_W', 'BASE Tab', 'X920', ' V9 ', 'ATLAS W', 'OPENC', 'OPEN2'], true)) {
            return (new Mobile\ZteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['lutea', 'bs 451', 'orange hi 4g', 'orange reyo', 'n9132', 'grand s flex', 'e8q+', 's8q', 's7q'], false)) {
            return (new Mobile\ZteFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/NX\d{3}/', $useragent)) {
            return (new Mobile\ZteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('orange', false)) {
            return (new Mobile\OrangeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('beeline', false)) {
            return (new Mobile\BeelineFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('digma', false)) {
            return (new Mobile\DigmaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('axgio', false)) {
            return (new Mobile\AxgioFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('zopo', false)) {
            return (new Mobile\ZopoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ultrafone', false)) {
            return (new Mobile\UltrafoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('malata', false)) {
            return (new Mobile\MalataFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('starway', false)) {
            return (new Mobile\StarwayFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('starmobile', false)) {
            return (new Mobile\StarmobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('logicom', false)) {
            return (new Mobile\LogicomFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gigabyte', false)) {
            return (new Mobile\GigabyteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('qumo', false)) {
            return (new Mobile\QumoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('celkon', false)) {
            return (new Mobile\CelkonFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('bravis', false)) {
            return (new Mobile\BravisFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('fnac', false)) {
            return (new Mobile\FnacFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tcl', false)) {
            return (new Mobile\TclFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('radxa', false)) {
            return (new Mobile\RadxaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xolo', false)) {
            return (new Mobile\XoloFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dragon touch', false)) {
            return (new Mobile\DragonTouchFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ramos', false)) {
            return (new Mobile\RamosFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('woxter', false)) {
            return (new Mobile\WoxterFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' mt791 ', false)) {
            return (new Mobile\KeenHighFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ktouch', 'k-touch'], false)) {
            return (new Mobile\KtouchFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['g100w', 'stream-s110'], false)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ (a1|a3|b1|b3)\-/i', $useragent)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['wildfire', 'desire'], false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['a101it', 'a7eb', 'a70bht', 'a70cht', 'a70hb', 'a70s', 'a80ksc', 'a35dm', 'a70h2', 'a50ti'], false)) {
            return (new Mobile\ArchosFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['sprd', 'SPHS', 'B51+'], false)) {
            return (new Mobile\SprdFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB A742', true)) {
            return (new Mobile\WexlerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('VS810PP', true)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['vox s502 3g'], false)) {
            return (new Mobile\DigmaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(cs|vs|ps|tt|pt|lt|ct|ts|ns|ht)\d{3,4}[aempqs]/i', $useragent)) {
            return (new Mobile\DigmaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A400', true)) {
            return (new Mobile\CelkonFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A5000', true)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('4good', false)) {
            return (new Mobile\FourGoodFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A101', 'A500', 'Z200', 'Z500', ' T09 ', ' T08 ', ' T07 ', ' T06 ', ' T04 ', ' T03 ', ' S55 '], true)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A1002', 'A811'], true)) {
            return (new Mobile\LexandFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A120', 'A116', 'A114', 'A093', 'A065', ' A96 ', 'Q327'], true)) {
            return (new Mobile\MicromaxFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['smart tab 4g'], false)) {
            return (new Mobile\LenovoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['smart tab 4', 'vfd 600', '985n'], false)) {
            return (new Mobile\VodafoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['smarttab', 'smart tab', 's6000d'], false)) {
            return (new Mobile\LenovoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['S208', 'S550', 'S600', 'Z100 Pro'], true)) {
            return (new Mobile\CubotFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('a1000s', false)) {
            return (new Mobile\XoloFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('s750', false)) {
            return (new Mobile\BeneveFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('blade', false)) {
            return (new Mobile\ZteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' z110', false)) {
            return (new Mobile\XidoFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ (a|e|v|z|s)\d{3} /i', $useragent)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AT-AS40SE', true)) {
            return (new Mobile\WolgangFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AT1010-T', true)) {
            return (new Mobile\LenovoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('utstarcom', false)) {
            return (new Mobile\UtStarcomFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['FP1', 'FP2'], true)) {
            return (new Mobile\FairphoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('videocon', false)) {
            return (new Mobile\VideoconFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mastone', false)) {
            return (new Mobile\MastoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('BLU', true)) {
            return (new Mobile\BluFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nuqleo', false)) {
            return (new Mobile\NuqleoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('wexler', false)) {
            return (new Mobile\WexlerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('exeq', false)) {
            return (new Mobile\ExeqFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ergo', false)) {
            return (new Mobile\ErgoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pulid', false)) {
            return (new Mobile\PulidFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dexp', false)) {
            return (new Mobile\DexpFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('keneksi', false)) {
            return (new Mobile\KeneksiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gionee', false)) {
            return (new Mobile\GioneeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('reeder', false)) {
            return (new Mobile\ReederFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('globex', false)) {
            return (new Mobile\GlobexFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MTC', true)) {
            return (new Mobile\MtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('oukitel', false)) {
            return (new Mobile\OukitelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('itel', false)) {
            return (new Mobile\ItelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('wileyfox', false)) {
            return (new Mobile\WileyfoxFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/le ?x\d{3}/i', $useragent)) {
            return (new Mobile\LeecoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('le 1 pro', false)) {
            return (new Mobile\LeecoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['loox', 'uno_x10', 'xelio', 'neo_quad10', 'ieos_quad', 'sky plus', 'maven_10_plus', 'space10_plus', 'adm816', 'noon', 'xpress', 'genesis', 'tablet-pc-4', 'kinder-tablet', 'evolution12', 'mira', 'score_plus', 'pro q8 plus', 'rapid7lte', 'neo6_lte', 'rapid_10'], false)) {
            return (new Mobile\OdysFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['DARKMOON', 'DARKSIDE', 'CINK PEAX 2', 'JERRY', 'BLOOM', 'SLIDE', 'LENNY', 'GETAWAY', 'WAX', 'KITE', 'BARRY', 'HIGHWAY', 'OZZY', 'RIDGE', 'PULP', 'SUNNY', 'FEVER', 'PLUS', 'SUNSET', 'DARKNIGHT', 'FIZZ', 'U FEEL', 'CINK SLIM', 'ROBBY'], true)) {
            return (new Mobile\WikoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('e-boda', false)) {
            return (new Mobile\EbodaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['l5510', 'rainbow'], false)) {
            return (new Mobile\WikoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ARK', true)) {
            return (new Mobile\ArkFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Magic', true)) {
            return (new Mobile\MagicFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('BQS', true)) {
            return (new Mobile\BqFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/BQ \d{4}/', $useragent)) {
            return (new Mobile\BqFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('aquaris', false)) {
            return (new Mobile\BqFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('wopad', false)) {
            return (new Mobile\WopadFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('anka', false)) {
            return (new Mobile\AnkaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lemon', false)) {
            return (new Mobile\LemonFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lava', false)) {
            return (new Mobile\LavaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sop', false)) {
            return (new Mobile\SopFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vsun', false)) {
            return (new Mobile\VsunFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('advan', false)) {
            return (new Mobile\AdvanFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('velocity', false)) {
            return (new Mobile\VelocityMicroFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('allview', false)) {
            return (new Mobile\AllviewFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('myphone', false)) {
            return (new Mobile\MyphoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('turbo-x', false)) {
            return (new Mobile\TurboxFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tagi', false)) {
            return (new Mobile\TagiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('avvio', false)) {
            return (new Mobile\AvvioFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('myTAB', true)) {
            return (new Mobile\MytabFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/iPh\d\,\d/', $useragent)) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Puffin\/[\d\.]+I(T|P)/', $useragent)) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dataaccessd', false)) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/iuc ?\(/i', $useragent)) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Pre/', $useragent) && !preg_match('/Presto/', $useragent)) {
            return (new Mobile\HpFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ME\d{3}[A-Z]/', $useragent)) {
            return (new Mobile\AsusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['padfone', 'transformer', 'slider sl101', 'eee_701', 'tpad_10'], false)) {
            return (new Mobile\AsusFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(K|P)0[0-2][0-9a-zA-Z]/', $useragent)) {
            return (new Mobile\AsusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tesla', false)) {
            return (new Mobile\TeslaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('doro', false)) {
            return (new Mobile\DoroFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('captiva', false)) {
            return (new Mobile\CaptivaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('elephone', false)) {
            return (new Mobile\ElephoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('eSTAR', true)) {
            return (new Mobile\EstarFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('cyrus', false)) {
            return (new Mobile\CyrusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('QtCarBrowser', true)) {
            return (new Mobile\TeslaMotorsFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/m(b|e|z)\d{3}/i', $useragent)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/WX\d{3}/', $useragent)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mtech', false)) {
            return (new Mobile\MtechFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['vodafone smart 4 max', 'smart 4 turbo'], false)) {
            return (new Mobile\VodafoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['onetouch', 'one_touch', 'one touch', 'v860', 'vodafone smart', 'vodafone 975n', 'vodafone 875', 'vodafone 785', 'vf-795', 'vf-895n', 'm812c', 'telekom puls'], false)) {
            return (new Mobile\AlcatelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xperia', false)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' droid', 'milestone', 'xoom', 'razr hd', ' z '], false)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['h30-u10', 'kiw-', 'chc-', 'che2-', 'ath-', 'mha-', 'cam-', 'frd-', 'nem-', 'pra-', 'plk-', 'lon-', 'duk-', 'ale-', 'gra-', 'vtr-', 'was-', 'bln-', 'ideos', 'u8500', 'vodafone 858', 'vodafone 845', 'ascend', 'm860', 'h60-l', ' p6 ', 'hi6210sft'], false)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vodafone 890n', false)) {
            return (new Mobile\YulongFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['a315c', 'vpa'], false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['one s', 'one x'], false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/OP\d{3}/', $useragent)) {
            return (new Mobile\OlivettiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SGP\d{3}/', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/sgpt\d{2}/i', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/VS\d{3}/', $useragent)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['surftab', 'vt10416', 'breeze 10.1 quad', 'xintroni10.1', 'st70408_4'], false)) {
            return (new Mobile\TrekStorFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AT\d{2,3}/', $useragent)) {
            return (new Mobile\ToshibaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['FOLIO_AND_A', 'TOSHIBA_AC_AND_AZ', 'folio100'], false)) {
            return (new Mobile\ToshibaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['PAP', 'PMP', 'PMT', 'PSP'], true)) {
            return (new Mobile\PrestigioFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['PJ83100', '831C', 'Evo 3D GSM', 'Eris 2.1', '0PCV1', 'MDA'], true)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/adr\d{4}/i', $useragent)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['NEXT', 'DATAM803HC'], true)) {
            return (new Mobile\NextbookFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' c7 ', ' h1 ', ' cheetah ', ' x12 ', ' x16 ', ' x17_s '], false)) {
            return (new Mobile\CubotFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mt10b', false)) {
            return (new Mobile\ExcelvanFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mt10', false)) {
            return (new Mobile\MtnFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['m1009', 'mt13', 'kp-703'], false)) {
            return (new Mobile\ExcelvanFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['MT6582/', 'mn84l_8039_20203'], true)) {
            return $this->loader->load('general mobile device', $useragent);
        }

        if (preg_match('/(S|L|W|M)T\d{2}/', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(S|M)K\d{2}/', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SO\-\d{2}(B|C|D|E|G)/', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('L50u', true)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NOOK', true)) {
            return (new Mobile\BarnesNobleFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('iQ1055', true)) {
            return (new Mobile\MlsFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/IQ\d{3,4}/', $useragent)) {
            return (new Mobile\FlyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/FS\d{3,4}/', $useragent)) {
            return (new Mobile\FlyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Phoenix 2', true)) {
            return (new Mobile\FlyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('VTAB1008', true)) {
            return (new Mobile\VizioFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB10-400', true)) {
            return (new Mobile\YarvikFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TQ\d{3}/', $useragent)) {
            return (new Mobile\GoCleverFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RMD\-\d{3,4}/', $useragent)) {
            return (new Mobile\RitmixFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['TERRA_101', 'ORION7o'], true)) {
            return (new Mobile\GoCleverFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AX\d{3}/', $useragent)) {
            return (new Mobile\BmobileFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/FreeTAB \d{4}/', $useragent)) {
            return (new Mobile\ModecomFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Venue', true)) {
            return (new Mobile\DellFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['funtab', 'zilo'], false)) {
            return (new Mobile\OrangeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['OV-', 'Solution 7III'], true)) {
            return (new Mobile\OvermaxFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/MID\d{3}/', $useragent)) {
            return (new Mobile\MantaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FWS610_EU', true)) {
            return (new Mobile\PhicommFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FX2', true)) {
            return (new Mobile\FaktorZweiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AN\d{1,2}/', $useragent)) {
            return (new Mobile\ArnovaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ARCHM\d{3}/', $useragent)) {
            return (new Mobile\ArnovaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['POV', 'TAB-PROTAB'], true)) {
            return (new Mobile\PointOfViewFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/PI\d{4}/', $useragent)) {
            return (new Mobile\PhilipsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SAMURAI10', true)) {
            return (new Mobile\ShiruFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Ignis 8', true)) {
            return (new Mobile\TbTouchFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FUNC', true)) {
            return (new Mobile\DfuncFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/iD(j|n|s|x|r)(D|Q)?\d{1,2}/', $useragent)) {
            return (new Mobile\DigmaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('GM', true)) {
            return (new Mobile\GeneralMobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('K1 turbo', true)) {
            return (new Mobile\KingzoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' A10 ', 'MP907C'], true)) {
            return (new Mobile\AllWinnerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('shield tablet', false)) {
            return (new Mobile\NvidiaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['K910L', ' K1 ', ' A1', ' A65 ', ' A60 ', 'YOGA Tablet', 'Tab2A7-', 'P770', 'ZUK ', ' P2 ', 'YB1-X90L', 'B5060', 'S1032X', 'X1030X'], true)) {
            return (new Mobile\LenovoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB7iD', true)) {
            return (new Mobile\WexlerFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ZP\d{3}/', $useragent)) {
            return (new Mobile\ZopoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xiaomi', false)) {
            return (new Mobile\XiaomiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/s450\d/i', $useragent)) {
            return (new Mobile\DnsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MB40II1', false)) {
            return (new Mobile\DnsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' M3 ', 'F103 Pro', ' E7 '], true)) {
            return (new Mobile\GioneeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['w100', 'w200', ' w8'], false)) {
            return (new Mobile\ThlFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/NT\-\d{4}(S|P|T|M)/', $useragent)) {
            return (new Mobile\IconBitFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Primo76', true)) {
            return (new Mobile\MsiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/T[GXZ]\d{2,3}/', $useragent)) {
            return (new Mobile\IrbisFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/YD\d{3}/', $useragent)) {
            return (new Mobile\YotaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('X-pad', true)) {
            return (new Mobile\TexetFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TM\-\d{4}/', $useragent)) {
            return (new Mobile\TexetFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('visio', false)) {
            return (new Mobile\OdysFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/OK\d{3}/', $useragent)) {
            return (new Mobile\SunupFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' G3 ', 'P509'], true)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['c660', 'ls670', 'vm670', 'ln240', 'optimus g'], false)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['zera f', 'zera_f', 'boost iise', 'ice2', 'prime s', 'explosion'], false)) {
            return (new Mobile\HighscreenFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('iris708', true)) {
            return (new Mobile\AisFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('L930', true)) {
            return (new Mobile\CiotcudFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('X8+', true)) {
            return (new Mobile\TrirayFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Surfer 7.34', 'M1_Plus', 'D7.2 3G', 'RioPlay'], true)) {
            return (new Mobile\ExplayFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Art 3G', true)) {
            return (new Mobile\ExplayFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('PMSmart450', true)) {
            return (new Mobile\PmediaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['F031', 'SCL24', 'ACE', 'SCT21', 'N900+'], true)) {
            return (new Mobile\SamsungFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ImPAD', true)) {
            return (new Mobile\ImpressionFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['TAB917QC-8GB', 'TAB785DUAL'], true)) {
            return (new Mobile\SunstechFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['M7T', 'P93G', 'i75', 'M83g', ' M6 ', 'M6pro', 'M9pro', 'PIPO', ' T9 '], true)) {
            return (new Mobile\PipoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['OT-'], true)) {
            return (new Mobile\AlcatelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('N8000D', true)) {
            return (new Mobile\SamsungFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/[4-9]0[0-7]\d(A|D|M|N|X|Y)/', $useragent)) {
            return (new Mobile\AlcatelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MD948G', true)) {
            return (new Mobile\MwayFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' V3 ', true)) {
            return (new Mobile\InewFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/PX\-\d{4}/', $useragent)) {
            return (new Mobile\IntegoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Smartphone650', true)) {
            return (new Mobile\MasterFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MX Enjoy TV BOX', true)) {
            return (new Mobile\GeniatechFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['P3000', 'P8000', 'P9000'], true)) {
            return (new Mobile\ElephoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('M5301', true)) {
            return (new Mobile\IruFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('GV7777', true)) {
            return (new Mobile\PrestigioFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' N1 ', true)) {
            return (new Mobile\NokiaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RM\-\d{3,4}/', $useragent) && !preg_match('/(nokia|microsoft)/i', $useragent)) {
            return (new Mobile\RossMoorFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RM\-\d{3,4}/', $useragent)) {
            return (new Mobile\NokiaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['5130c-2', 'lumia', 'arm; 909', 'id336', 'genm14', 'n900'], false)) {
            return (new Mobile\NokiaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/N\d{4}/', $useragent)) {
            return (new Mobile\StarFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Rio R1', 'GSmart_T4'], true)) {
            return (new Mobile\GigabyteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('7007HD', true)) {
            return (new Mobile\PerfeoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('PT-GF200', true)) {
            return (new Mobile\PantechFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/IM\-A\d{3}(L|K)/', $useragent)) {
            return (new Mobile\PantechFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('K-8S', true)) {
            return (new Mobile\KeenerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('M601', true)) {
            return (new Mobile\AocFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('H1+', true)) {
            return (new Mobile\HummerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Impress_L', true)) {
            return (new Mobile\VertexFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['M040', 'MZ-MX5', 'MX4', ' M9 ', ' M2 ', 'M032', 'PRO 5'], true)) {
            return (new Mobile\MeizuFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NEO-X5', true)) {
            return (new Mobile\MinixFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Numy_Note_9', true)) {
            return (new Mobile\AinolFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Novo7Fire', true)) {
            return (new Mobile\AinolFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB-97E-01', true)) {
            return (new Mobile\ReellexFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vega', false)) {
            return (new Mobile\AdventFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['dream', ' x9 ', 'x315e', 'z715e', 'amaze'], false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['netbox', ' x10 ', ' e10i ', ' xst2 ', ' x2 ', 'r800x', 's500i', 'x1i', 'x10i'], false)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TF300T', true)) {
            return (new Mobile\AsusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['vf685', '5095b', '5095i', '5095k', '5095y', 'vf-1497'], false)) {
            return (new Mobile\TclFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('F10X', true)) {
            return (new Mobile\NextwayFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' m8 ', false)) {
            return (new Mobile\AmlogicFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SPX\-\d/', $useragent)) {
            return (new Mobile\SimvalleyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AdTab 7 Lite', true)) {
            return (new Mobile\AdspecFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Neon-N1', 'WING-W2'], true)) {
            return (new Mobile\AxgioFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['T108', 'T118'], true)) {
            return (new Mobile\TwinovoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TOUAREG8_3G', true)) {
            return (new Mobile\AccentFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('chagall', false)) {
            return (new Mobile\PegatronFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Turbo X6', true)) {
            return (new Mobile\TurboPadFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['HW-W718', 'W717', 'HM-N501-FL', ' L52 ', ' G30 ', 'PAD G781'], true)) {
            return (new Mobile\HaierFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Air A70', true)) {
            return (new Mobile\RoverPadFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SP-6020 QUASAR', true)) {
            return (new Mobile\WooFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('M717R-HD', true)) {
            return (new Mobile\VastKingFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Q10S', true)) {
            return (new Mobile\WopadFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ctab785r16-3g', 'pgn-', 'pkt-301'], false)) {
            return (new Mobile\CondorFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RP\-UDM\d{2}/', $useragent)) {
            return (new Mobile\VericoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['UQ785-M1BGV', 'KM-UQM11A'], true)) {
            return (new Mobile\VericoFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RG\d{3}/', $useragent)) {
            return (new Mobile\RugGearFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('T9666-1', true)) {
            return (new Mobile\TelsdaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('N003', true)) {
            return (new Mobile\NeoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AP-105', true)) {
            return (new Mobile\MitashiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('H7100', true)) {
            return (new Mobile\FeitengFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['x909', 'r815', 'r8106', 'u705t', 'find7', 'a37f', 'r7f', 'r7sf', 'x9006', 'x9076', ' 1201 '], false)) {
            return (new Mobile\OppoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xda', false)) {
            return (new Mobile\O2Factory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['kkt20', 'pixel v2+', ' x17 '], false)) {
            return (new Mobile\LavaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('iris', false) && !$s->contains('windows', false)) {
            return (new Mobile\LavaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Pulse', 'myTouch4G', 'Ameo'], true)) {
            return (new Mobile\TmobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['redmi', 'note 4', '2014813', '2014011', '2015562'], false)) {
            return (new Mobile\XiaomiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('G009', true)) {
            return (new Mobile\YxtelFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/U\d{4}/', $useragent)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('PICOpad_S1', true)) {
            return (new Mobile\AxiooFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Adi_5S', true)) {
            return (new Mobile\ArtelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Norma 2', true)) {
            return (new Mobile\KeneksiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('DM015K', true)) {
            return (new Mobile\KyoceraFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('KC-S701', true)) {
            return (new Mobile\KyoceraFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('T880G', true)) {
            return (new Mobile\EtulineFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['studio 5.5', 'studio xl 2'], false)) {
            return (new Mobile\BluFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['f3_pro', 'y6_piano', 'y6 max', 'x5max_pro', 'x9pro', ' t6 '], false)) {
            return (new Mobile\DoogeeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB-970', true)) {
            return (new Mobile\PrologyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AP-804', true)) {
            return (new Mobile\AssistantFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(atlantis|discovery) \d{3,4}/i', $useragent)) {
            return (new Mobile\BlaupunktFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('discovery', false)) {
            return (new Mobile\GeneralMobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('IP1020', true)) {
            return (new Mobile\DexFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A66A', true)) {
            return (new Mobile\EvercossFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('t720', false)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('One', true)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ARM; WIN JR', 'ARM; WIN HD'], true)) {
            return (new Mobile\BluFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('n820', false)) {
            return (new Mobile\AmoiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('N90FHDRK', true)) {
            return (new Mobile\YuandaoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('n90 dual core2', false)) {
            return (new Mobile\YuandaoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lencm900hz', false)) {
            return (new Mobile\LencoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['tp10.1-1500dc', 'tp8-1200qc', 'tu-1489a', 'tp9.7-1500dc'], false)) {
            return (new Mobile\IonikFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TPC\-/', $useragent)) {
            return (new Mobile\JaytechFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' G9 ', true)) {
            return (new Mobile\MastoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['dl1', 'eluga_arc_2'], false)) {
            return (new Mobile\PanasonicFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('zt180', false)) {
            return (new Mobile\ZenithinkFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('e1107', false)) {
            return (new Mobile\YusuFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('IS05', true)) {
            return (new Mobile\SharpFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('P4D SIRIUS', true)) {
            return (new Mobile\NvsblFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('smartpad', false)) {
            return (new Mobile\EinsUndEinsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['n930', 'cp8676_i02', 'cp8298_i00', 'w713', '8079', '5860s'], false)) {
            return (new Mobile\CoolpadFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('la-m1', false)) {
            return (new Mobile\BeidouFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('i4901', false)) {
            return (new Mobile\IdeaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ft 4008', 'ft_4008'], false)) {
            return (new Mobile\LifewareFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['lead 1', 'lead 2', 't1_plus', 'elite 4', 'elite 5', 'shark 1'], false)) {
            return (new Mobile\LeagooFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['v1_viper', 'a4you', 'p5_quad', 'x2_soul', 'ax4nano', 'x1_soul'], false)) {
            return (new Mobile\AllviewFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('forward_art', false)) {
            return (new Mobile\NgmFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gnet', false)) {
            return (new Mobile\GnetFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('hive v 3g', false)) {
            return (new Mobile\TurboxFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('titanium octane', false)) {
            return (new Mobile\KarbonnFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['yq601', 'sm919', 'sm801', 'sm701'], false)) {
            return (new Mobile\SmartisanFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('turkcell', false)) {
            return (new Mobile\TurkcellFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['m-pp', 'm-mp'], false)) {
            return (new Mobile\MediacomFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' v1 ', false)) {
            return (new Mobile\MaxtronFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tecno', false)) {
            return (new Mobile\TecnoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' C2 ', true)) {
            return (new Mobile\ZopoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A0001', true)) {
            return (new Mobile\OneplusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('l-ement500', false)) {
            return (new Mobile\LogicomFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('is04', false)) {
            return (new Mobile\KddiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['be pro', 'paris', 'vienna', 'u007', 'future'], false)) {
            return (new Mobile\UlefoneFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ls\-\d{4}/i', $useragent)) {
            return (new Mobile\LyfFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['x7 plus', 'x5max', 'x5pro'], false)) {
            return (new Mobile\VivoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['t1x plus', 'vandroid'], false)) {
            return (new Mobile\AdvanFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sense golly', false)) {
            return (new Mobile\IproFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sirius_qs', false)) {
            return (new Mobile\VoninoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dl 1803', false)) {
            return (new Mobile\DlFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('s10q-3g', false)) {
            return (new Mobile\SmartbookFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('trekker-x1', false)) {
            return (new Mobile\CrosscallFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['neffos', 'tp601a', 'tp601b', 'tp601c', 'tp601e'], false)) {
            return (new Mobile\TplinkFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ht16', 'ht17', 'ht20', 'ht7 pro'], false)) {
            return (new Mobile\HomtomFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' s30 ', false)) {
            return (new Mobile\FireflyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['apollo', 'thor'], false)) {
            return (new Mobile\VerneeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('1505-a02', false)) {
            return (new Mobile\ItelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['tb1016', 'tb717-3g'], false)) {
            return (new Mobile\AcmeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mitab think', false)) {
            return (new Mobile\WolderFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['pixel', 'gce x86 phone'], false)) {
            return (new Mobile\GoogleFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['nt.i10g2', 'nt. p10g2'], false)) {
            return (new Mobile\NinetecFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['909t', ' m13 '], false)) {
            return (new Mobile\MpieFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('z30', false)) {
            return (new Mobile\MagnusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('up580', false)) {
            return (new Mobile\UhappyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('swift', false)) {
            return (new Mobile\WileyfoxFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('m9c max', false)) {
            return (new Mobile\BqeelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('qt-10', false)) {
            return (new Mobile\QmaxFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ilium l820', false)) {
            return (new Mobile\LanixFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['s501m 3g', 't700i_3g'], false)) {
            return (new Mobile\FourGoodFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ixion_es255', 'h135'], false)) {
            return (new Mobile\DexpFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/N[BP]\d{2,3}/', $useragent)) {
            return (new Mobile\BravisFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('atl-21', false)) {
            return (new Mobile\ArtizleeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('w032i-c3', false)) {
            return (new Mobile\IntelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['cs24', 'cs25'], false)) {
            return (new Mobile\CyrusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' t02 ', false)) {
            return (new Mobile\ChanghongFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['crown', 'bv5000', 'bv6000', 'bv7000', ' r6 ', ' a8 ', 'alife p1', 'omega_pro', 'dm550'], false)) {
            return (new Mobile\BlackviewFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('k107', false)) {
            return (new Mobile\YuntabFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['london', 'hammer_s'], false)) {
            return (new Mobile\UmiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['elegance', 'slimtab7_3gr'], false)) {
            return (new Mobile\KianoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['u7 plus', 'u16 max', 'k6000 pro', 'k4000', 'k10000'], false)) {
            return (new Mobile\OukitelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['vi8 plus', 'hibook'], false)) {
            return (new Mobile\ChuwiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('jy-', false)) {
            return (new Mobile\JiayuFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['NOVA'], true)) {
            return (new Mobile\CatSoundFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gsmart', false)) {
            return (new Mobile\GigabyteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' m10 ', 'edison 3'], false)) {
            return (new Mobile\BqFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' m20 ', false)) {
            return (new Mobile\TimmyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['tp41-3g', 'tp31-3g'], false)) {
            return (new Mobile\TheqFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('g708 oc', false)) {
            return (new Mobile\ColorflyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('q880_xk', false)) {
            return (new Mobile\TianjiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('c55', false)) {
            return (new Mobile\CtroniqFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['l900', 'xm100'], false)) {
            return (new Mobile\LandvoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' k5 ', false)) {
            return (new Mobile\KomuFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' x6 ', false)) {
            return (new Mobile\VotoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' m71 ', false)) {
            return (new Mobile\EplutusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' d10 ', false)) {
            return (new Mobile\XgodyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('hudl 2', false)) {
            return (new Mobile\TescoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tab1024', false)) {
            return (new Mobile\IntensoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ifive mini 4s', false)) {
            return (new Mobile\FnfFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('i545', true)) {
            return (new Mobile\SamsungFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' i10 ', false)) {
            return (new Mobile\SymphonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' arc ', false)) {
            return (new Mobile\KoboFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('m92d-3g', false)) {
            return (new Mobile\SumvierFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('m502', false)) {
            return (new Mobile\NavonFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' c4 ', false)) {
            return (new Mobile\TreviFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' f5 ', false)) {
            return (new Mobile\TecnoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('a88x', false)) {
            return (new Mobile\AlldaymallFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('bs1078', false)) {
            return (new Mobile\YonesToptechFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('excellent8', false)) {
            return (new Mobile\TomtecFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ih-g101', false)) {
            return (new Mobile\InnoHitFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('g900', false)) {
            return (new Mobile\IppoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nimbus 80qb', false)) {
            return (new Mobile\WoxterFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['gs55-6', 'gs53-6'], false)) {
            return (new Mobile\GigasetFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vkb011b', false)) {
            return (new Mobile\FengxiangFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('trooper_x55', false)) {
            return (new Mobile\KazamFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('end_101g-test', false)) {
            return (new Mobile\BlaupunktFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' n3 ', false)) {
            return (new Mobile\GooPhoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('king 7', false)) {
            return (new Mobile\PptvFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['admire sxy', 'cinemax'], false)) {
            return (new Mobile\ZenFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('1501_m02', false)) {
            return (new Mobile\ThreeSixtyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('9930i', false)) {
            return (new Mobile\StarFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['d4c5', 'k9c6'], false)) {
            return (new Mobile\TeclastFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('t72', false)) {
            return (new Mobile\OystersFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ftj?\d{3}/i', $useragent)) {
            return (new Mobile\FreetelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ns-14t004', 'ns-p10a6100'], false)) {
            return (new Mobile\InsigniaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('blaster 2', false)) {
            return (new Mobile\JustFiveFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('picasso', false)) {
            return (new Mobile\BlubooFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('strongphoneq4', false)) {
            return (new Mobile\EvolveoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['shift7', 'shift5.2'], false)) {
            return (new Mobile\ShiftFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('k960', false)) {
            return (new Mobile\JlinkszFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('q8002', false)) {
            return (new Mobile\CryptoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tm785m3', false)) {
            return (new Mobile\NuVisionFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ektra', false)) {
            return (new Mobile\KodakFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('presto', false) && !$s->contains('opera', false)) {
            return (new Mobile\OplusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kt107', false)) {
            return (new Mobile\BdfFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('m52_red_note', false)) {
            return (new Mobile\MlaisFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('I5', true)) {
            return (new Mobile\SopFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('i5', true)) {
            return (new Mobile\VsunFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ARM;/', $useragent)
            && preg_match('/Windows NT 6\.(2|3)/', $useragent)
            && !preg_match('/WPDesktop/', $useragent)
        ) {
            return (new Mobile\MicrosoftFactory($this->loader))->detect($useragent, $s);
        }

        return $this->loader->load('general mobile device', $useragent);
    }
}
