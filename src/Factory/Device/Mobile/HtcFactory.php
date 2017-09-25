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
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HtcFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'po58220'                 => 'htc po58220',
        'one_e8'                  => 'htc one e8',
        'htc 10 evo'              => 'htc 10 evo',
        'one a9'                  => 'htc one a9',
        'u ultra'                 => 'htc u ultra',
        'u play'                  => 'htc u play',
        'm9u'                     => 'htc m9u',
        'm9w'                     => 'htc m9w',
        'htc 10'                  => 'htc 10',
        'u11'                     => 'htc u11',
        ' x9 '                    => 'htc x9',
        'one me dual sim'         => 'htc one me dual sim',
        '0pcv1'                   => 'htc 0pcv1',
        'nexus one'               => 'htc nexus one',
        'nexus-one'               => 'htc nexus one',
        'nexusone'                => 'htc nexus one',
        'nexus 9'                 => 'htc nexus 9',
        'nexushd2'                => 'htc nexus hd2',
        'nexus evohd2'            => 'htc nexus hd2',
        '8x by htc'               => 'htc windows phone 8x',
        'pm23300'                 => 'htc windows phone 8x',
        '8s by htc'               => 'htc 8s',
        'radar c110e'             => 'htc radar c110e',
        'radar; orange'           => 'htc radar c110e',
        'radar 4g'                => 'htc radar 4g',
        'radar'                   => 'htc radar',
        'hd7'                     => 'htc t9292',
        'mondrian'                => 'htc t9292',
        '7 mozart'                => 'htc t8698',
        't8282'                   => 'htc touch hd t8282',
        '7 pro t7576'             => 'htc t7576',
        'hd2_t8585'               => 'htc t8585',
        'htc hd2'                 => 'htc t8585',
        'htc_hd2'                 => 'htc t8585',
        'hd mini'                 => 'htc mini t5555',
        'hd_mini'                 => 'htc mini t5555',
        'titan'                   => 'htc x310e',
        '7 trophy'                => 'htc spark',
        'mwp6985'                 => 'htc spark',
        '0p6b180'                 => 'htc 0p6b180',
        '0p6b'                    => 'htc 0p6b',
        'one_m9plus'              => 'htc m9 plus',
        'one m9plus'              => 'htc m9 plus',
        'one_m9'                  => 'htc m9',
        'one m9'                  => 'htc m9',
        'one_m8s'                 => 'htc m8s',
        'one m8s'                 => 'htc m8s',
        'one_m8'                  => 'htc m8',
        'one m8'                  => 'htc m8',
        'pn07120'                 => 'htc pn07120',
        'pn071'                   => 'htc pn071',
        'one x+'                  => 'htc pm63100',
        'one_x+'                  => 'htc pm63100',
        'onexplus'                => 'htc pm63100',
        'one xl'                  => 'htc pj83100 xl',
        'one_xl'                  => 'htc pj83100 xl',
        'one x'                   => 'htc pj83100 x',
        'one_x'                   => 'htc pj83100 x',
        'onex'                    => 'htc pj83100 x',
        'pj83100'                 => 'htc pj83100 x',
        'one v'                   => 'htc one v',
        'one_v'                   => 'htc one v',
        'one sv'                  => 'htc one sv',
        'one_sv'                  => 'htc one sv',
        'onesv'                   => 'htc one sv',
        'one s'                   => 'htc pj401',
        'one_s'                   => 'htc pj401',
        'ones'                    => 'htc pj401',
        'one mini 2'              => 'htc one mini 2',
        'one_mini_2'              => 'htc one mini 2',
        'one mini'                => 'htc one mini',
        'one_mini'                => 'htc one mini',
        'one max'                 => 'htc one max',
        'one_max'                 => 'htc one max',
        'himauhl_htc_asia_tw'     => 'htc one max',
        'x315e'                   => 'htc x315e',
        'runnymede'               => 'htc x315e',
        'sensation 4g'            => 'htc sensation 4g',
        'sensation_4g'            => 'htc sensation 4g',
        'sensation xl'            => 'htc x315e',
        'sensationxl'             => 'htc x315e',
        'sensation xe'            => 'htc sensation xe beats z715e',
        'sensationxe'             => 'htc sensation xe beats z715e',
        'htc_sensation-orange-ls' => 'htc z710 ls',
        'htc_sensation-ls'        => 'htc z710 ls',
        'sensation z710e'         => 'htc z710e',
        'sensation_z710e'         => 'htc z710e',
        'sensation'               => 'htc z710',
        'pyramid'                 => 'htc z710',
        'evo 3d gsm'              => 'htc evo 3d gsm',
        'x515a'                   => 'htc x515a',
        'x515c'                   => 'htc x515c',
        'x515e'                   => 'htc x515e',
        'evo 3d'                  => 'htc x515m',
        'evo_3d'                  => 'htc x515m',
        'evo3d'                   => 'htc x515m',
        'x515m'                   => 'htc x515m',
        'x515'                    => 'htc x515',
        'desirez_a7272'           => 'htc a7272',
        'desire z'                => 'htc desire z',
        'desire_z'                => 'htc desire z',
        'desirez'                 => 'htc desire z',
        'desire x'                => 'htc t328e',
        'desire_x'                => 'htc t328e',
        'desirex'                 => 'htc t328e',
        'desire v'                => 'htc desire v',
        'desire_v'                => 'htc desire v',
        'desirev'                 => 'htc desire v',
        's510e'                   => 'htc s510e',
        'desire sv'               => 'htc desire sv',
        'desire_sv'               => 'htc desire sv',
        'desiresv'                => 'htc desire sv',
        'desire s'                => 'htc desire s',
        'desire_s'                => 'htc desire s',
        'desires'                 => 'htc desire s',
        'desirehd-orange-ls'      => 'htc desire hd ls',
        'a9191'                   => 'htc a9191',
        'a9192'                   => 'htc inspire 4g',
        'desire hd'               => 'htc desire hd',
        'desirehd'                => 'htc desire hd',
        'desire c'                => 'htc 1000c',
        'desire_c'                => 'htc 1000c',
        'desirec'                 => 'htc 1000c',
        'desire 820s'             => 'htc desire 820s',
        'desire_820s'             => 'htc desire 820s',
        'desire_820'              => 'htc desire 820',
        'desire 820'              => 'htc desire 820',
        'desire 816g'             => 'htc desire 816g',
        'desire_816g'             => 'htc desire 816g',
        'desire 816'              => 'htc desire 816',
        'desire_816'              => 'htc desire 816',
        '0p4e2'                   => 'htc 0p4e2',
        'desire 601'              => 'htc 0p4e2',
        'desire_601'              => 'htc 0p4e2',
        'desire 728g'             => 'htc desire 728g',
        'desire_728g'             => 'htc desire 728g',
        'desire 728'              => 'htc desire 728',
        'desire 700'              => 'htc desire 700',
        'desire_700'              => 'htc desire 700',
        'desire 626g'             => 'htc desire 626g',
        'desire_626g'             => 'htc desire 626g',
        'desire 626'              => 'htc desire 626',
        'desire_626'              => 'htc desire 626',
        'desire 620g'             => 'htc desire 620g',
        'desire_620g'             => 'htc desire 620g',
        'desire 610'              => 'htc desire 610',
        'desire_610'              => 'htc desire 610',
        'desire 600c'             => 'htc desire 600c',
        'desire_600c'             => 'htc desire 600c',
        'desire 600'              => 'htc desire 600',
        'desire_600'              => 'htc desire 600',
        'desire 530'              => 'htc desire 530',
        'desire_530'              => 'htc desire 530',
        'desire 526g'             => 'htc desire 526g',
        'desire_526g'             => 'htc desire 526g',
        'desire 516'              => 'htc desire 516',
        'desire_516'              => 'htc desire 516',
        'desire 510'              => 'htc desire 510',
        'desire_510'              => 'htc desire 510',
        'desire 500'              => 'htc desire 500',
        'desire_500'              => 'htc desire 500',
        'desire 400'              => 'htc desire 400',
        'desire_400'              => 'htc desire 400',
        'desire 320'              => 'htc desire 320',
        'desire_320'              => 'htc desire 320',
        'desire 310'              => 'htc desire 310',
        'desire_310'              => 'htc desire 310',
        'desire 300'              => 'htc desire 300',
        'desire_300'              => 'htc desire 300',
        'desire eye'              => 'htc desire eye',
        'desire_eye'              => 'htc desire eye',
        'desire_a8181'            => 'htc a8181',
        'desire'                  => 'htc desire',
        'wildfires-orange-ls'     => 'htc wildfire s ls',
        'wildfires-ls'            => 'htc wildfire s ls',
        ' a315c '                 => 'htc a315c',
        'a510a'                   => 'htc a510a',
        'wildfire_a3333'          => 'htc a3333',
        'a510e'                   => 'htc a510e',
        'adr6230'                 => 'htc adr6230',
        'wildfire s'              => 'htc a510',
        'wildfires'               => 'htc a510',
        'wildfire'                => 'htc wildfire',
        'vision'                  => 'htc vision',
        'velocity 4g x710s'       => 'htc x710s',
        'velocity_4g_x710s'       => 'htc x710s',
        'velocity 4g'             => 'htc velocity 4g',
        'velocity_4g'             => 'htc velocity 4g',
        'velocity'                => 'htc velocity',
        'touch_diamond2'          => 'htc touch diamond 2',
        'tattoo'                  => 'htc tattoo',
        'touch_pro2_t7373'        => 'htc t7373',
        'touch2'                  => 'htc t3335',
        't329d'                   => 'htc t329d',
        't328w'                   => 'htc t328w',
        't328d'                   => 'htc t328d',
        'smart_f3188'             => 'htc smart f3188',
        'shooteru'                => 'htc shooter u',
        'salsa'                   => 'htc salsa',
        'butterfly_s_901s'        => 'htc s901s',
        'incredible s'            => 'htc s710e',
        'incredibles'             => 'htc s710e',
        's710e'                   => 'htc s710e',
        'rhyme'                   => 'htc s510b',
        's510b'                   => 'htc s510b',
        'ruby'                    => 'htc ruby',
        'p3700'                   => 'htc p3700',
        'magic'                   => 'htc magic',
        'legend'                  => 'htc legend',
        'hero'                    => 'htc hero',
        'a6288'                   => 'htc hero',
        'glacier'                 => 'htc glacier',
        'g21'                     => 'htc g21',
        'flyer p512'              => 'htc p512',
        'flyer_p512'              => 'htc p512',
        'flyer p510e'             => 'htc p510e',
        'flyer_p510e'             => 'htc p510e',
        'flyer'                   => 'htc flyer',
        'pc36100'                 => 'htc pc36100',
        'evo 4g'                  => 'htc pc36100',
        'kingdom'                 => 'htc pc36100',
        'dream'                   => 'htc dream',
        'd820mu'                  => 'htc d820mu',
        'd820us'                  => 'htc d820us',
        'd820u'                   => 'htc d820u',
        'click'                   => 'htc click',
        'eris'                    => 'htc eris',
        ' c2'                     => 'htc c2',
        'bravo'                   => 'htc bravo',
        'butterfly'               => 'htc butterfly',
        'adr6350'                 => 'htc adr6350',
        'gratia'                  => 'htc a6380',
        'a6380'                   => 'htc a6380',
        'a6366'                   => 'htc a6366',
        'a3335'                   => 'htc a3335',
        'chacha'                  => 'htc a810e',
        'explorer'                => 'htc a310e',
        'a310e'                   => 'htc a310e',
        'amaze'                   => 'htc amaze 4g',
        'htc7088'                 => 'htc 7088',
        'htc6990lvw'              => 'htc htc6990lvw',
        'htc6500lvw'              => 'htc m7 (htc6500lvw)',
        'htc6435lvw'              => 'htc htc6435lvw',
        'htc 919d'                => 'htc 919d',
        '831c'                    => 'htc 831c',
        'htc 809d'                => 'htc 809d',
        'htc 802t'                => 'htc 802t',
        'htc802t'                 => 'htc 802t',
        'htc 802d'                => 'htc 802d',
        'htc 606w'                => 'htc desire 606w',
        'htc d516d'               => 'htc desire 516',
        'vpa_touch'               => 'htc vpa touch',
        'htc_vpacompactiv'        => 'htc vpa compact iv',
        'mda_vario_v'             => 'htc mda vario v',
        'mda vario/3'             => 'htc mda vario iii',
        'mda vario/2'             => 'htc mda vario ii',
        'mda compact/3'           => 'htc mda compact iii',
        'mda_compact_v'           => 'htc mda compact v',
        'mda compact'             => 'htc mda compact',
        'v3600'                   => 'htc v3600',
        'v1510'                   => 'htc v1510',
        's620'                    => 'htc s620',
        'p3350'                   => 'htc p3350',
        'htc-8500'                => 'htc 8500',
        'x7500'                   => 'htc x7500',
        'p6300'                   => 'htc p6300',
        'p3300'                   => 'htc p3300',
        'mteor'                   => 'htc mteor',
    ];

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
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAny(['One', 'ONE'], true)) {
            return $this->loader->load('htc m7', $useragent);
        }

        return $this->loader->load('general htc device', $useragent);
    }
}
