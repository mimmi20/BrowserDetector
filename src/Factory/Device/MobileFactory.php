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
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory\DeviceFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Psr\Log\LoggerInterface;

class MobileFactory implements DeviceFactoryInterface
{
    private $factories = [
        '/startrail|starxtrem|starshine|staraddict|starnaute|startext|startab/i' => 'sfr', // also includes the 'Tunisie Telecom' and the 'Altice' branded devices
        '/hiphone/i' => 'hiphone',
        '/blackberry/i' => 'rim',
        '/asus(?!-nexus)|padfone|transformer|tf300t|slider sl101|me302(c|kl)|me301t|me371mg|me17(1|2v|3x)|eee_701|tpad_10|tx201la|p01t_1|(k0[01][0-9a-z]|z00d|z00yd|p(00[8acl]|01y|02[12347]) build|z017d)[);\/ ]/i' => 'asus',
        '/feiteng/i' => 'feiteng',
        '/mypad (1000|750) ?hd/i' => 'yooz',
        '/(myphone|mypad|mytab)[ _][^;\/]+ build|cube_lte|mytab10ii|hammer active/i' => 'myphone', // must be before Cube
        '/cube|(u[0-9]+gt|k8gt)|i1-3gd|i15-tcl/i' => 'cube',
        '/tcl[ \-][a-z0-9]+|tcl[_ \-][^;\/]+ build|tclgalag60|vf-1497|vf685/i' => 'tcl',
        '/pantech/i' => 'pantech',
        '/touchpad\/\d+\.\d+|hp-tablet|hp ?ipaq|webos.*p160u|slate|hp [78]|compaq [7|8]|hp; [^;\/)]+|pre\/|pixi|palm|cm_tenderloin/i' => 'hp',
        '/hisense [^);\/]+|hs-(g|u|eg?|i|l|t|x)[0-9]+[a-z0-9\-]*|e270bsa|m470bs[ae]|e2281|eg680|f5281|u972|e621t|w2003/i' => 'hisense',
        '/sony/i' => 'sony',
        '/accent/i' => 'accent',
        '/amoi/i' => 'amoi',
        '/CCE /' => 'cce',
        '/blaupunkt|atlantis[_ ](1001a|1010a|a10\.g40[23])|discovery[_ ](102c|111c|1000c|1001a?)|endeavour[_ ](785|101[glm]|1000|1001|101[03]|1100)|polaris[_ ]803|end_101g-test/i' => 'blaupunkt', // must be before Onda
        '/archos|a101it|a7eb|a70bht|a70cht|a70hb|a70s|a80ksc|a35dm|a70h2|a50ti/i' => 'archos',
        '/irulu/i' => 'irulu',
        '/turbo-x/i' => 'turbo-x',
        '/arnova/i' => 'arnova',
        '/coby/i' => 'coby',
        '/o\+|oplus/i' => 'oplus',
        '/goly/i' => 'goly',
        '/WM[0-9]{4}/' => 'wondermedia',
        '/comag/i' => 'comag',
        '/cosmote/i' => 'cosmote',
        '/creative/i' => 'creative',
        '/dell/i' => 'dell',
        '/denver|ta[cdq]-[0-9]+|sdq-55024l grey/i' => 'denver',
        '/sharp|shl2[25]|shv31|is05|[0-9]{3}sh|sh-?[0-9]{2,4}[cdefuw]/i' => 'sharp',
        '/flytouch/i' => 'flytouch',
        '/nec[ _\-]|kgt\/2\.0|portalmmm\/1\.0 (db|n)|(portalmmm|o2imode)\/2.0[ ,]n|n-06[de]|n[79]05i/i' => 'nec', // must be before docomo
        '/docomo/i' => 'docomo',
        '/easypix|easypad|easyphone|junior 4\.0/i' => 'easypix',
        '/xoro/i' => 'xoro',
        '/explay(?!er)|actived[ _]|atlant |informer[ _][0-9]+|cinematv 3g|surfer[ _][0-9\.]|squad[ _][0-9\.]|onliner[1-3]|rioplay|m1_plus|d7\.2 3g|art 3g/i' => 'explay',
        '/goophone/i' => 'goophone',
        '/g-tide/i' => 'gtide',
        '/turbo ?pad/i' => 'turbopad',
        '/hummer/i' => 'hummer',
        '/oysters/i' => 'oysters',
        '/gfive/i' => 'gfive',
        '/iconbit/i' => 'iconbit',
        '/sxz/i' => 'sxz',
        '/aoc/i' => 'aoc',
        '/jolla/i' => 'jolla',
        '/kazam/i' => 'kazam',
        '/kddi/i' => 'kddi',
        '/kobo/i' => 'kobo',
        '/lenco/i' => 'lenco',
        '/le ?pan/i' => 'lepan',
        '/(ta10ca3|tm105a?|tr10cs1)[);\/ ]/i' => 'ecs',
        '/gem[0-9]+[a-z]*/i' => 'gemini',
        '/minix/i' => 'minix',
        '/allwinner/i' => 'allwinner',
        '/supra/i' => 'supra',
        '/prestigio/i' => 'prestigio',
        '/nintendo/i' => 'nintendo',
        '/(q7a\+?)[);\/ ]/i' => 'crius-mea',
        '/crosscall|odyssey_plus|odyssey s1|trekker-[msx][123]/i' => 'crosscall',
        '/panasonic|panatv[0-9]+|viera\/|p902i[);\/ ]|eluga[ _]|fz-n1|dl1|p55 max/i' => 'panasonic',
        '/pandigital/i' => 'pandigital',
        '/phicomm/i' => 'phicomm',
        '/pomp/i' => 'pomp',
        '/sanyo/i' => 'sanyo',
        '/siemens/i' => 'siemens',
        '/benq/i' => 'siemens',
        '/sagem/i' => 'sagem',
        '/ouya/i' => 'ouya',
        '/trevi/i' => 'trevi',
        '/cowon/i' => 'cowon',
        '/digma[_ ][^;\/]+ build|hit ht707[10]mg|citi 1902 3g|citi [a-z0-9]+ 3g c[st]500[67]pg|idjd7|idrq10[ _]3g|idxd8 3g|idnd7|hit 4g ht7074ml|idx5|idx10|idx7|mvm900h(wz|c)|mvm908hcz|idxd10 3g|idxd[45]|idxq5|idxd7[_ ]3g|ps604m|pt452e|linx a400 3g lt4001pg|linx c500 3g lt5001pg|linx ps474s|ns6902ql|ns9797mg|(optima|platina|plane)[ _][em]?([0-9\.st]+|prime)([ _][43]g)?|tt7026mw|vox[ _][0-9\.a-z]+[_ ][43]g/i' => 'digma',
        '/hudl 2|hudl ht7s3/i' => 'tesco',
        '/homtom|ht[0-9]{1,2} ?(pro)?| s16 /i' => 'homtom',
        '/hosin/i' => 'hosin',
        '/hasee/i' => 'hasee',
        '/intex/i' => 'intex',
        '/mt-gt-a9500|gt-a7100/i' => 'htm', // must be before samsung (gt rule)
        '/gt-h/i' => 'feiteng',
        '/gt-9000/i' => 'star',
        '/sc-74jb|sc-91mid/i' => 'supersonic',
        '/xperia|playstation|sgpt[0-9]{2}|l[0-9]{2}u/i' => 'sony',
        '/flipkart|xt811/i' => 'flipkart',
        '/trekstor|surftab|vt10416|breeze 10\.1 quad|xintroni10\.1|st70408_4|[sv]t[0-9]{5}/i' => 'trekstor',
        '/ct(10[0123]0|7[12]0|820)(w|fr)?[);\/ ]/i' => 'carrefour',
        '/(hw-)?(huawei|ideos|honor[ _]?|(h60-l(01|02|03|04|11|12)|h30-(c00|l01m?|l02|u10|t00|t10)|g621-tl00m?|plk-(al10|cl00|tl00|tl01h?|ul00|l01)|scl-(al00|cl00|tl00h?|l01)|cam-tl00|chc-u[02]3|ch(e2?|m)-[cut]l00[hm]?|che1-cl[12]0|che2-l11|chm-u01|fig-lx1|dli-(al10|l[24]2|tl20)|kiw-l21|kiw-tl00h|u(8100|8110|8230|8500|8661|8665|8667|8800|8818|8860|9200|9508)|nem-l[52][21]|ple-70[13]l|bln-(l2[124]|al10)|bnd-(al10|l21)|lld-al[012]0|pra-l[ax]1|pra-al00x|rne-l22|y220-u00)[);\/ ])|bucare y330-u05|hi6210sft|vodafone[ _]858|vodafone 845|ascend|m860| p6 |enjoy 7 plus|g6600|p7mini|p8_max/i' => 'huawei',
        '/nokia(?!; gt-i8750)|lumia|maemo rx|portalmmm\/2\.0 n7|portalmmm\/2\.0 nk|nok[0-9]+|symbian.*\s[a-z0-9]+$|rx-51 n900|rm-(1031|104[25]|106[234567]|107[234567]|1089|109[0269]|1109|111[34]|1127|1141|1154)|ta-[0-9]{4} build|(adr|android) 5\.[01].* n1|5130c-2|arm; 909|id336|genm14/i' => 'nokia', // also includes the 'Microsoft' branded Lumia devices
        '/captiva[ _-][^;\/]+ build/i' => 'captiva',
        '/supertab[ _-]?[^;\/]+ build/i' => 'supertab',
        '/vi8 plus|hibook|hi10 pro|cw-hi8-super/i' => 'chuwi',
        '/umi(digi)?[ _]|iron[ _]|london(?!test)|hammer_s|z2 pro|plus e|c note|super(?!sonic)|s2 lite/i' => 'umi',
        '/mot|(?<!an|hs|md |mocor|m)droid ?(build|[a-z0-9]+)|droid-bionic|portalmmm\/2.0 (e378i|l6|l7|v3)|xoom [^;\/]*build|(?<!ne)(xt|mz|mb|me)[0-9]{3,4}[a-z]?(\(defy\)|-[01][0-9]|-backflip)?( build|\))|milestone|razr hd|(?<!desire) z |t720/i' => 'motorola',
        '/galaxy s3 ex/i' => 'hdc',
        '/lingwin/i' => 'lingwin',
        '/boway/i' => 'boway',
        '/sprd|b51\+|sphs on hsdroid/i' => 'sprd',
        '/zuum|stedi|magno/i' => 'zuum',
        '/samsung[is \-;\/](?!galaxy nexus)|galaxy(?! nexus)|(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum|ek|yp)-|g710[68]|n8000d|n[579]1[01]0|f031|n900\+|sc[lt]2[0-9]|isw11sc|s7562|sghi[0-9]{3}|i8910|i545|i(7110|9100|9300)|blaze|s8500/i' => 'samsung', // must be before orange and sprint
        '/texet|x-pad|navipad|tm-[0-9]{4}/i' => 'texet', // must be before odys
        '/(ever(glory|shine|miracle|mellow|classic|trendy|fancy|vivid|slim|glow|magic|smart|star)[^\/;]*) build|e70[25]0hd|e7914hg|e8050h[dg]|e8051hd|e9054hd/i' => 'evertek', // must be before Magic and Odys
        '/inm[0-9]{3,4}|tab1024/i' => 'intenso',
        '/ngm[_ ][a-z0-9]+|(forward|dynamic)[ _]?[^\/;]+(build|\/)/i' => 'ngm',
        '/tolino/i' => 'tolino',
        '/odys|xelio_next|(maven|space|tao|thor)_?x?10|connect(7pro|8plus)|loox|uno_x10|xelio|neo_quad10|ieos_quad|sky plus|maven_10_plus|maven10_hd_plus_3g|maven_x10_hd_lte|space10_plus|adm816|noon|xpress|genesis|tablet-pc-4|kinder-tablet|evolution12|mira|score_plus|pro q8 plus|rapid7lte|neo6_lte|rapid_10|visio(?!n)|pace10|falcon_10_plus_3g|goal_10_plus_3g/i' => 'odys',
        '/next|next[0-9]|datam803hc|nx785qc8g|nxm900mc|nx008hd8g|nx010hi8g|nxm908hc|nxm726/i' => 'nextbook',
        '/infinix/i' => 'infinix',
        '/bv[5-8]000|dm550|crown| r6 | a8 |alife [ps]1|omega_pro|a7pro/i' => 'blackview',
        '/karbonn|titanium|machfive|sparkle v|s109|k9 smart grand/i' => 'karbonn', // must be before acer
        '/micromax[ \-\_]?[a-z0-9]+|(p70221|a121|a120|a116|a114|a093|a065| a96| a50| a47|q327)( build|\))|mid1014/i' => 'micromax',
        '/zte|racer|smart ?(tab(10|7)|4g|ultra 6)|orange (hi 4g|reyo)|beeline pro|lutea|bs 451|n9132|grand s flex|e8q\+|s8q|s7q|blade|momodesign md droid|[ \-]a310(?!e)|atlas[_ ]w|base tab|kis plus|n799d|n9101|n9180|n9510|n9515|n9520|n9521|n9810|n918st|n958st|nx[0-9]{2,3}|open[c2]|u9180| v9 |v788d|v8000|v9180|x501|x920|z221|z768g|z820|z835|z855|z851m?|z98[1236](dl)?/i' => 'zte', // must be before orange and acer
        '/smart tab 4(?!g)|vfd [0-9]{3}|985n|vodafone smart 4 max|smart 4 turbo|vodafone 975(?!n)|vodacom/i' => 'vodafone',
        '/qmobile|q-smart|qtab| x900 /i' => 'qmobile', // must be before acer
        '/shield tablet/i' => 'nvidia',
        '/kingzone|k1[ _]turbo/i' => 'kingzone',
        '/gigabyte|rio r1|gsmart/i' => 'gigabyte',
        '/lenovo|smart ?tab|idea(tab|pad)|thinkpad|yoga tablet|(?<!mi) [ak]1 (?!lite)|a1_07| a6[05] |at1010-t|b5032|b5060|b5531|e1041x|e10[56]0x|k910l|p1060x|(adr|android) [67].* p2|p770|s1032x|s6000d|tab2a7-|x1030x|yb1-x90l|zuk | k6 build|a238t|z2131/i' => 'lenovo',
        '/fujitsu|m532|m305|f-0[0-9][def]|is11t|fartm933kz/i' => 'fujitsu',
        '/pentagram|monster x5|quadra 7 ultraslim/i' => 'pentagram',
        '/quadro/i' => 'quadro',
        '/akai|glory[ _](o2|l3|g5)|eco e2|tab-7800|tab-7830|tab-9800q?|x6 metal/i' => 'akai',
        '/iris708/i' => 'ais',
        '/lava[ _]|iris[ _]?[^\/;]+(\)| build)|a76 build|x1 selfie build|x41 plus build|flair z1|kkt20|pixelv1|pixel v2\+?|( x17|x1 atom|x5 4g| z[679]0) build/i' => 'lava',
        '/htc|sprint (apa|atp)|adr(?!910l)[a-z0-9]+|nexushd2|amaze[ _]4g[);\/ ]|(desire|sensation|evo ?3d|incredibles|wildfire|butterfly)[ _]?([^;\/]+) build|(amaze[ _]4g|(?<!gi|iph)one ?[xelsv\+]+)[);\/ ]|spv e6[05]0|one mini|one m8|x525a|pg86100|pc36100|xv6975|pj83100[);\/ ]|0pcv1|2pyb2|0pja10|0pja2|t-mobile_espresso|mda[ _]|vpa_touch|(831c|a315c| x9|(?<!xolo|nexus|cubot|blu life) one|dream) build|eris 2\.1/i' => 'htc',
        '/ac0731b|ac0732c|ac1024c|ac7803c|bc9710am|el72b|er71b|lc0720c|lc0723b|lc0725b|lc0804b|lc0808b|lc0809b|lc0810c|lc0816c|lc0901d|lc1016c|mt0724b|mt0729b|mt0729d|mt0739d|mt0811b|mt0812e|mt7801c|oc1020a|qs9719d|qs9718c|qs9715f|qs1023h|qs0815c|qs0730c|qs0728c|qs0717d|qs0716d|qs0715c|rc0709b|rc0710b|rc0718c|rc0719h|rc0721b|rc0722c|rc0726b|rc0734h|rc0743h|rc0813c|rc0817c|rc1018c|rc1019g|rc1025f|rc1301c|rc7802f|rc9711b|rc9712c|rc9716b|rc9717b|rc9724c|rc9726c|rc9727f|rc9730c|rc9731c|ts0807b|ts1013b|vm0711a|vm1017a/i' => '3q',
        '/lg(?!e)|lge(?! nexus)|g3mini|vs[0-9]{3}| g3 |p713|p509|c660 |(?<!s)(ls|vm|ln)[0-9]{3}|optimus g|l-0[0-9][cde]|lm-(g710|x410\.fn|x210)/i' => 'lg',
        '/sprint/i' => 'sprint',
        '/videocon/i' => 'videocon',
        '/gigaset|gs5[357]-6|gs185|gs270|gs370_plus/i' => 'gigaset',
        '/(dns|airtab)[ _\-]([^;\/]+)build|s4503q|s4505m/i' => 'dns',
        '/s-tell/i' => 'stell',
        '/bliss/i' => 'bliss',
        '/poly ?pad/i' => 'polypad',
        '/doov/i' => 'doov',
        '/ov-|solution 7iii|qualcore 1010/i' => 'overmax',
        '/alcatel|alc[a-z0-9]+|one[ _]?touch|idol3|(4003a|4009a|4013[dmx]|4017x|4024d|4027[adx]|4032d|4034[df]|4047[adx]|4049g|5009[ad]|5010[dux]|5011a|5015[adx]|5016a|5017a|5019d|5022[dx]|5023f|5025[dg]|5026[ad]|5038x|5042[ad]|5045[dtx]|5046d|5049g|8050[gx]|5051[dx]|5052d|5054[dnswx]|5056[dx]|5058[aijty]|5059[adijtxy]|5065[dnx]|5070[dx]|5080x|5095[biky]|5099[adiuy]|6016[dx]|6036y|6037y|6039[hky]|6043d|6044d|6045[hky]|6050[afy]|6055[kp]|6058d|6070[koy]|7048x|7040n|7070x|8030y|8050d|9001[dx]|9002x|9003x|9005x|9008[adx]|9010x|9022x|i213|i216x|v860|vodafone (smart|785|875|975n)|vf-(795|895n)|m812c|telekom puls|ot-[89][09][0-9])[);\/ ]/i' => 'alcatel',
        '/toshiba/i' => 'toshiba',
        '/viewsonic/i' => 'viewsonic',
        '/view(pad|phone)/i' => 'viewsonic',
        '/(blu|dash)[ _][^\/;]+ build|vivo (iv|4\.65)|studio 5\.5|studio xl 2|studio view xl|(blu|arm); win (jr|hd)/i' => 'blu',
        '/tp[0-9]{1,2}(\.[0-9])?-[0-9]{4}|tu-[0-9]{4}|l1001 4g/i' => 'ionik',
        '/neffos|tp[0-9]{3}/i' => 'tp-link',
        '/logicpd|zoom2|nook ?color/i' => 'logicpd',
        '/nook|bn[tr]v[0-9]+/i' => 'barnesnoble',
        '/koobee/i' => 'koobee',
        '/infocus|m370i|vzh|if9031|if9021/i' => 'infocus',
        '/MTC /' => 'mtc',
        '/ark benefit m3s/i' => 'ark',
        '/meizu|mz-[a-z]|(m04[05]|m35[1356]|mx[ -]?[2345]( pro)?|(mz-)?m[1-6] note|m57[18]c|m3[esx]|m03[12]|m1 metal|m1 e|m[29]|m2 e|pro [567]|pro 7-h)[);\/ ]/i' => 'meizu',
        '/TBD[0-9]{4}|TBD[BCG][0-9]{3,4}/' => 'zeki',
        '/t118|t108/i' => 'twinovo',
        '/POV|TAB-PROTAB|MOB-5045/' => 'point-of-view',
        '/philips|pi[0-9]{4}/i' => 'philips',
        '/t1144/i' => 'cello',
        '/symphony| i10 | h150 | h400 /i' => 'symphony',
        '/thl[ _]|w[12]00| w8| t11/i' => 'thl',
        '/spice/i' => 'spice',
        '/mobistel|cynus[ _][^\/;]+/i' => 'mobistel',
        '/dg[0-9]{3,4}|x[679]pro|x5max_pro|bl5000| x[23]0 |f3_pro|y6_piano|y6 max| t6 |s60 lite/i' => 'doogee',
        '/aquaris|bq [^\/;]+ build|bqs-400[57]| m10 |edison 3/i' => 'bq',
        '/vivo|x[0-9] ?(plus|max|pro)/i' => 'vivo',
        '/haipai/i' => 'haipai',
        '/megafon/i' => 'megafon',
        '/yuanda/i' => 'yuanda',
        '/pocketbook/i' => 'pocketbook',
        '/goclever|quantum|aries|insignia|orion_|elipso|terra_101|orion7o|tq[0-9]{3}/i' => 'goclever',
        '/senseit/i' => 'senseit',
        '/twz/i' => 'twz',
        '/i-mobile/i' => 'i-mobile',
        '/evercoss|a66a|a74a/i' => 'evercoss',
        '/dino(?!saur)/i' => 'dino',
        '/shaan|iball|snap 4g2/i' => 'iball',
        '/modecom/i' => 'modecom',
        '/kiano/i' => 'kiano',
        '/smartfren/i' => 'smartfren',
        '/(?<!-)orange|spv|funtab|zilo/i' => 'orange',
        '/(pgn-?[456][012][0-9]|pkt-?301|phs-601)[;\/\) ]|ctab[^\/;]+ build|plume l1/i' => 'condor',
        '/beeline/i' => 'beeline',
        '/axgio/i' => 'axgio',
        '/zopo/i' => 'zopo',
        '/malata/i' => 'malata',
        '/starway/i' => 'starway',
        '/starmobile/i' => 'starmobile',
        '/logicom/i' => 'logicom',
        '/qumo/i' => 'qumo',
        '/celkon|a400/i' => 'celkon',
        '/fnac/i' => 'fnac',
        '/radxa/i' => 'radxa',
        '/dragon touch/i' => 'dragon-touch',
        '/ramos/i' => 'ramos',
        '/woxter/i' => 'woxter',
        '/k-?touch/i' => 'ktouch',
        '/mastone/i' => 'mastone',
        '/nuqleo/i' => 'nuqleo',
        '/wexler/i' => 'wexler',
        '/exeq/i' => 'exeq',
        '/4good/i' => 'fourgood',
        '/utstar/i' => 'utstarcom',
        '/pipo/i' => 'pipo',
        '/tesla/i' => 'tesla',
        '/doro/i' => 'doro',
        '/allview|v1_viper|a4you|p[59]_(quad|energy)|ax4nano|x[124]_soul|p41_emagic/i' => 'allview',
        '/energy[ _-]?[^;\/]+ build/i' => 'energy-sistem',
        '/elephone[ _\-][^\/;]+ build|p[369]000( ?pro| ?plus|\+| ?02)? build|p8_mini/i' => 'elephone',
        '/wopad/i' => 'wopad',
        '/anka/i' => 'anka',
        '/lemon/i' => 'lemon',
        '/sop-/i' => 'sop',
        '/vsun/i' => 'vsun',
        '/velocity/i' => 'velocitymicro',
        '/tagi/i' => 'tagi',
        '/avvio/i' => 'avvio',
        '/e-boda/i' => 'eboda',
        '/ergo/i' => 'ergo',
        '/pulid/i' => 'pulid',
        '/dexp/i' => 'dexp',
        '/keneksi/i' => 'keneksi',
        '/reeder/i' => 'reeder',
        '/globex/i' => 'globex',
        '/morefine/i' => 'morefine',
        '/vernee/i' => 'vernee',
        '/iocean/i' => 'iocean',
        '/intki/i' => 'intki',
        '/i-joy/i' => 'ijoy',
        '/inq/i' => 'inq',
        '/iberry/i' => 'iberry',
        '/kingsun/i' => 'kingsun',
        '/komu/i' => 'komu',
        '/kopo/i' => 'kopo',
        '/koridy/i' => 'koridy',
        '/kumai/i' => 'kumai',
        '/konrow/i' => 'konrow',
        '/eSTAR/' => 'estar',
        '/NTT/' => 'nttsystem',
        '/iq1055/i' => 'mls', // must be before Fly
        '/fly[ _]|flylife|phoenix 2|fs50[1-9]|fs511|fs551|fs40[1-7]|fs452|fs451|fs454|4fs06|meridian-|iq[0-9]{3,}i?[ _]?(quad|firebird|quattro|turbo|magic)?( build|[;\/\)])/i' => 'fly',
        '/smartpad7503g|smartpad970s2(3g)?|m[_\-][mps]p[0-9a-z]+|m-ipro[0-9a-z]+/i' => 'mediacom',
        '/bmobile[ _]|ax[0-9]{3}/i' => 'bmobile',
        '/hlv-t[a-z0-9]+/i' => 'hi-level',
        '/ t02 /i' => 'changhong',
        '/bravis|a501 bright|nb(10[56]|751|7[145])|np101/i' => 'bravis', // must be before acer
        '/touchlet|x7g|x10\.|xa100/i' => 'pearl',
        '/acer|liquid|(?<!zte blade |[0-9])a(100|101(b2?|b2-lz|c)?|110|200|210|211|500|501|510|511|700|701)[);\/ ]|android.*v3[67]0[);\/ ]|android.*z1[23456]0 build|android.*z200 build|android.*z410 build|android.*z5\d{2} build|android.*t0[2346789] build|a1-81[01]|a1-830|a1-84[01]|a3-a[12345][01]|b1-7[1235678][01]|b1-7[23]3|b1-8[1235]0|b1-a71|b3-a[12]0|b3-a3[02]|b3-a40|b3-a50|(e39|e140|e310|e380|e600|g100w|s55|s5[012]0) build|da[0-9]+hq?l[);\/ ]|stream-s110/i' => 'acer',
        '/technisat|technipad|aqipad|techniphone/i' => 'technisat',
        '/q8002/i' => 'crypto', // must be before xolo
        '/xolo|a1000s|q10[01]0i?|q[678]00s?|q2000|omega[ _][0-9]|era 2/i' => 'xolo',
        '/cherry|flare2x|flare_hd_max|fusion bolt/i' => 'cherry-mobile',
        '/android.*iphone|ucweb.*adr.*iphone/i' => 'xianghe',
        '/(?<!tr|m|med)ipad|ipod(?!der)|(?<!like )iphone|like mac os x|darwin|cfnetwork|dataaccessd|iuc ?\(|iph[0-9]\,[0-9]|puffin\/[0-9\.]+i[tp]/i' => 'apple',
        '/mtech/i' => 'mtech',
        '/lexand/i' => 'lexand',
        '/meeg/i' => 'meeg',
        '/mofut/i' => 'mofut',
        '/majestic/i' => 'majestic',
        '/mlled/i' => 'mlled',
        '/m\.t\.t\./i' => 'mtt',
        '/meu/i' => 'meu',
        '/noain/i' => 'noain',
        '/nexian/i' => 'nexian',
        '/opsson/i' => 'opsson',
        '/qilive|q4t10in/i' => 'qilive',
        '/quechua/i' => 'quechua',
        '/stx/i' => 'stonex',
        '/sunvan/i' => 'sunvan',
        '/vollo/i' => 'vollo',
        '/nuclear/i' => 'nuclear',
        '/uniscope/i' => 'uniscope',
        '/voto/i' => 'voto',
        '/la-m1|la2-t/i' => 'beidou',
        '/yusun/i' => 'yusun',
        '/ytone/i' => 'ytone',
        '/zeemi/i' => 'zeemi',
        '/bush/i' => 'bush',
        '/B[iI][rR][dD][ _\-]/' => 'bird',
        '/desay/i' => 'desay',
        '/datang/i' => 'datang',
        '/EBEST/' => 'ebest',
        '/ETON/' => 'eton',
        '/evolveo/i' => 'evolveo',
        '/telenor[ _]/i' => 'telenor',
        '/concorde/i' => 'concorde',
        '/readboy/i' => 'readboy',
        '/sencor/i' => 'sencor',
        '/axxion/i' => 'axxion',
        '/cnm[ \-](touchpad|tp)[ \-]([0-9\.]+)/i' => 'cnm',
        '/dslide ?[^;\/]+ build/i' => 'danew',
        '/grundig|gr?-tb[0-9]+[a-z]*|portalmmm\/2\.0 g/i' => 'grundig',
        '/hyundai|ultra air|ultra live/i' => 'hyundai',
        '/casper/i' => 'casper',
        '/noa[ _]/i' => 'noa',
        '/dialog k35/i' => 'dialog',
        '/auxus/i' => 'iberry',
        '/rm-(997|560)/i' => 'rossmoor',
        '/gtx75/i' => 'utstarcom',
        '/bluboo|picasso|xfire|maya/i' => 'bluboo',
        '/amazon|kindle|silk|kf(tt|ot|jwi|sowi|thwi|apwa|aswi|apwi|dowi|auwi|giwi|tbwi|mewi|fowi|sawi|sawa|suwi|arwi|thwa|jwa)|aft[st]|sd4930ur|fire2/i' => 'amazon',
        '/playbook|rim tablet|bb10|stv100|bb[ab]100-2|sth100-2|bbd100-1/i' => 'rim',
        '/ (b15|s[346]1|s[46]0) |b15q/i' => 'caterpillar',
        '/cat ?(nova|stargate|tablet|helix)/i' => 'catsound',
        '/mid0714|midc|pmid|prov?[0-9]{3}[b0-9]?|p4526a|p5006a/i' => 'polaroid',
        '/MID(1024|1125|1126|1045|1048|1060|1065|4331|7012|7015A?|7016|7022|7032|7035|7036|7042|7047|7048|7052|7065|7120|8024|8042|8048|8065|8125|8127|8128|9724|9740|9742)/' => 'coby',
        '/(?<!\/)MID713|MID(06[SN]|08[S]?|12|13|14|15|701|702|703|704|705(DC)?|706[AS]?|707|708|709|711|712|714|717|781|801|802|901|1001|1002|1003|1004( 3G)?|1005|1009|1010|7802|9701|9702)/' => 'manta',
        '/P[AS]P|PM[PT]/' => 'prestigio',
        '/nbpc724/i' => 'coby',
        '/wtdr1018/i' => 'comag',
        '/ziilabs|ziio7/i' => 'creative',
        '/p900i/i' => 'docomo',
        '/smart-e5/i' => 'efox',
        '/telepad/i' => 'xoro',
        '/conexis|sp5045v/i' => 'fnb',
        '/memup|slidepad|sp[0-9]{3}|spng[0-9]{3}/i' => 'memup',
        '/epad|p7901a/i' => 'zenithink',
        '/hsg[0-9]{4}|sn10t1|sn97t41w|sn1at71w\(b\)|sn70t51a|sn70t31?|t7-qc/i' => 'hannspree',
        '/pc1088/i' => 'honlin',
        '/sailfish/i' => 'jolla',
        '/Magic/' => 'magic',
        '/gionee|v1[0-9]{2}|gn[0-9]{3}| m[35] |f103| e7 | v6l |pioneer|dream_d1|(adr|android) 4\.2.* p2|m5_lite|p7 max|a1 lite/i' => 'gionee',
        '/nomi[ _-]|(a10100|c07000) build/i' => 'nomi',
        '/(adr|android) 4\.4.* n1/i' => 'newsman',
        '/(adr|android) 4\.0.* n1/i' => 'tizzbird',
        '/xiaomi|(mi [a-z0-9]+|mi-4c|mi-one[ _]?[a-z0-9]+|mix 2s?)[);\/ ]|hm[ _][^\/;]+ ?(build|miui|\))|(2014501|2014011|201481[138]|201302[23]|2013061) (build|miui)|redmi|note 4|mipad|poco(phone)?/i' => 'xiaomi',
        '/WeTab/' => 'neofonie',
        '/SIE-/' => 'siemens',
        '/CAL21|C771|C811/' => 'casio',
        '/oukitel|u7 plus|u16 max|k6000 pro|k6000 plus|k4000|k10000|universetap| u22 build/i' => 'oukitel',
        '/ouki|ok[au][0-9]{1,2}/i' => 'ouki',
        '/numy|novo[0-9]/i' => 'ainol',
        '/oneplus|one (a200[135]|e100[13])|a0001/i' => 'oneplus',
        '/ImPAD6213M_v2/' => 'impression',
        '/D6000/' => 'innos',
        '/kyocera|e6560|c6750|c6742|c6730|c6522n|c5215|c5170|c5155|c5120|dm015k|kc-s701|kyl21/i' => 'kyocera',
        '/medion|lifetab|p4501|p850x|e4004|e691x|p1050x|p1032x|p1040x|s1035x|p1035x|p4502|p851x|x1031x|x1060x|x5001|b5532/i' => 'medion',
        '/terra pad|pad1002/i' => 'wortmann',
        '/[ ;](l-?ement|l-ite|l-?ixir)|e[89]12|e731|e1031|kt712a_4\\.4|tab1062|tab950/i' => 'logicom',
        '/tech ?pad|xtab|dual c1081hd|s813g/i' => 'techpad',
        '/c15100m/i' => 'kurio',
        '/esperanza/i' => 'esperanza',
        '/A5000| [CDEFG][0-9]{4}/' => 'sony',
        '/PM-[0-9]{4}/' => 'sanyo',
        '/folio_and_a|toshiba_ac_and_az|folio100|at1s0|at[0-9]{2,3}|t-0[0-9][cd]/i' => 'toshiba',
        '/(aqua|cloud)[_ \.]/i' => 'intex',
        '/ultrafone/i' => 'zen',
        '/ mt791 /i' => 'keenhigh',
        '/sphs_on_hsdroid|pure 3/i' => 'mhorse',
        '/TAB A742|TAB7iD|TAB 10Q|ZEN [0-9]/' => 'wexler',
        '/A1002|A811|S[45]A[0-9]|SC7 PRO HD/' => 'lexand',
        '/s750/i' => 'beneve',
        '/ z110/i' => 'xido',
        '/a727/i' => 'azpen',
        '/onda|v919 3g air|v10 4g/i' => 'onda',
        '/tm785m3/i' => 'nuvision',
        '/m785|800p71d|800p3[12]c|101p51c|x1010|a1013r|s10-0g/i' => 'mecer',
        '/cubot|hafury|s20[08]|s308|s550|s600|z100 pro|note plus| c7 | h1 | cheetah | x1[268] | x17_s | r9 build/i' => 'cubot',
        '/coolpad|cp[0-9]{4}|c103 build|n930|5860s|8079|8190q|8295|vcr-i0|w713|3600i/i' => 'coolpad',
        '/AT-AS[0-9]{2}[DS]/' => 'wolfgang',
        '/vk-/i' => 'vkmobile',
        '/FP[12]/' => 'fairphone',
        '/le 1 pro|le 2|le max|le[ _]?x[0-9]{3}/i' => 'leeco',
        '/tecno| f5 | h7 |phantom6-plus/i' => 'tecno',
        '/comio|ct701g plus|ct701w/i' => 'comio',
        '/QtCarBrowser/' => 'teslamotors',
        '/s5003d_champ/i' => 'switel',
        '/SGP[0-9]{3}|X[ML][0-9]{2}[th]/' => 'sony',
        '/(YU|AO)[0-9]{4}/' => 'yu',
        '/vodafone 890n/i' => 'yulong',
        '/OP[0-9]{3}/' => 'olivetti',
        '/mt6515m-a1\+/i' => 'united',
        '/mt10b/i' => 'excelvan',
        '/mt10/i' => 'mtn',
        '/m1009|mt13|kp-703/i' => 'excelvan',
        '/MT6582\/|mn84l_8039_20203/' => 'unknown',
        '/mt6515m-a1\+/' => 'united',
        '/BIGCOOL|COOLFIVE|COOL-K|Just5|LINK5/' => 'konrow',
        '/PLT([^;\/]+) Build/' => 'proscan',
        '/[SLWM]T[0-9]{2}|[SM]K[0-9]{2}|SO-[0-9]{2}[BCDEFGH]/' => 'sony',
        '/RMD-[0-9]{3,4}/' => 'ritmix',
        '/free(way )?tab|xino z[0-9]+ x[0-9]+/i' => 'modecom',
        '/FX2/' => 'faktorzwei',
        '/AN[0-9]{1,2}|ARCHM[0-9]{3}/' => 'arnova',
        '/FUNC/' => 'dfunc',
        '/ZP[0-9]{3}/' => 'zopo',
        '/s450[0-9]/i' => 'dns',
        '/vtab1008/i' => 'vizio',
        '/tab(07|10)-[0-9]{3}|(luna|noble|xenta)[ \-]tab[0-9]/i' => 'yarvik',
        '/venue|xcd35/i' => 'dell',
        '/fws610_eu/i' => 'phicomm',
        '/samurai10/i' => 'shiru',
        '/ignis 8/i' => 'tbtouch',
        '/ a10 |mp907c/i' => 'allwinner',
        '/k107| k17 /i' => 'yuntab',
        '/ k18 /i' => 'newman',
        '/k1001l1b/i' => 'moonar',
        '/dps /i' => 'dps',
        '/convexa/i' => 'convexa',
        '/mb40ii1/i' => 'dns',
        '/w960/i' => 'sony',
        '/n003/i' => 'neo',
        '/ v1 /i' => 'maxtron',
        '/7007hd/i' => 'perfeo',
        '/haier| w[0-9]{3}[ )]|h[mtw]-[ginvw][0-9]{1,3}| l52 | g3[01]s? |pad g781|pad971/i' => 'haier',
        '/NT-[0-9]{4}[SPTM]/' => 'iconbit',
        '/T[GXZ][0-9]{2,3}/' => 'irbis',
        '/YD[0-9]{3}/' => 'yota',
        '/OK[0-9]{3}/' => 'sunup',
        '/ACE/' => 'samsung',
        '/PX-[0-9]{4}/' => 'intego',
        '/ip[0-9]{4}/i' => 'dex',
        '/element p501|element[ _]?(7|8|9\.7|10)/i' => 'sencor',
        '/elegance|intelect|cavion|slim ?tab ?(7|8|10)|core 10\.1 dual 3g/i' => 'kiano',
        '/ c4 |phablet [0-9]|tab[_ ]?(7|8|9|10)[_ ]?3g/i' => 'trevi',
        '/inew| v[0-9]-?[ace]?[ )]/i' => 'inew',
        '/(RP|KM)-U[DQ]M[0-9]{2}/' => 'verico',
        '/KM-/' => 'kttech',
        '/primo76|primo 91/i' => 'msi',
        '/zera[ _]f|boost iise|ice2|prime s|explosion/i' => 'highscreen',
        '/l930/i' => 'ciotcud',
        '/x8\+/i' => 'triray',
        '/pmsmart450/i' => 'pmedia',
        '/iusai/i' => 'opsson',
        '/d4c5|k9c6|c5j6|m5k8/i' => 'teclast',
        '/netbox| x10 | e1[05]i| x2 |r800x|s500i|x1i|x10i|[ls]39h|h3113|h3213|h3311|h4113|h8216|h8266|h8314|h8324|ebrd[0-9]{4}|502so|sol22|sov32/i' => 'sony',
        '/wileyfox|swift/i' => 'wileyfox',
        '/t-mobile|pulse|mytouch4g|ameo|garminfone/i' => 'tmobile',
        '/oppo|x90[0-9]{1,2}|n52[0-9]{2}|r[12678][0-9]{2,3}|u70[0-9]t|f1f|find7|a3[37]f|r7[ks]?f|r7plus[fm]| 1201 | 1107 |n1t|a160[13]|cph160[79]|cph1701|cph171[57]|cph172[379]|cph180[13]|cph1819|cph1859|cph1861|(adr|android) 4\.2.* n1|padm00|rmx1805/i' => 'oppo',
        '/leagoo|lead [12]|t1_plus|elite [45]|shark 1|s8_pro|m8 pro|kiicaa power/i' => 'leagoo',
        '/max2_plus_3g/i' => 'innjoo',
        '/advan|t1x plus|vandroid/i' => 'advan',
        '/general mobile|discovery|gm 5 plus/i' => 'general-mobile',
        '/wiko|dark(moon|side|night|full)|barry|birdy|bloom|cink|fever|fizz|harry|getaway| goa|highway|iggy|jimmy|jerry|kite|ozzy|plus|pulp|ridge|robby|slide|stairway|sublim|sunset|u feel|wax|l5510|lenny|rainbow|sunny|view (go|prime|xl)|view build|w_k[46]00|w_c800|wim lite/i' => 'wiko',
        '/(mpqc|mpdc)[0-9]{1,4}|ph[0-9]{3}|mid(7c|74c|82c|84c|801|811|701|711|170|77c|43c|102c|103c|104c|114c)|mp(843|717|718|843|888|959|969|1010|7007|7008)|mgp7/i' => 'mpman',
        '/N[0-9]{4}/' => 'star',
        '/medipad/i' => 'bewatec',
        '/nexus|google ?tv|glass|crkey[^a-z0-9]|google pixel|pixel build|pixel (xl|c|2|2 xl) build|gce x86 phone/i' => 'google',
        '/a1303|a309w|m651cy/i' => 'china-phone',
        '/i101mtk/i' => 'china-tablet',
        '/impad/i' => 'impression',
        '/tab917qc|tab785dual/i' => 'sunstech',
        '/m7t|p93g|i75|m83g| m6 |m[69]pro| t9 /i' => 'pipo',
        '/md948g/i' => 'mway',
        '/smartphone650/i' => 'master',
        '/mx enjoy tv box/i' => 'geniatech',
        '/m5301/i' => 'iru',
        '/gv7777/i' => 'prestigio',
        '/9930i/i' => 'star',
        '/m717r-hd/i' => 'vastking',
        '/m502/i' => 'navon',
        '/lencm900hz/i' => 'lenco',
        '/xm[13]00/i' => 'landvo',
        '/ m8 /i' => 'amlogic',
        '/m601/i' => 'aoc',
        '/IM-[AT][0-9]{3}[LKS]|ADR910L/' => 'pantech',
        '/SPX-[0-9]/' => 'simvalley',
        '/RG[0-9]{3}/' => 'ruggear',
        '/ap-105/i' => 'mitashi',
        '/AP-[0-9]{3}/' => 'assistant',
        '/ft[ _][0-9]{4}/i' => 'lifeware',
        '/(od|sm|yq)[0-9]{3}/i' => 'smartisan',
        '/ls-[0-9]{4}|f81e/i' => 'lyf',
        '/tb[0-9]{3,4}/i' => 'acme',
        '/nt\. ?(p|i)10g2/i' => 'ninetec',
        '/tp[0-9]{2}-3g/i' => 'theq',
        '/ftj?[0-9]{3}/i' => 'freetel',
        '/RUNE/' => 'bs-mobile',
        '/tlink|every35|primo[78]|qm73[45]-8g/i' => 'thomson',
        '/(i-style|iq) ?[0-9]/i' => 'i-mobile',
        '/pt-gf200/i' => 'pantech',
        '/k-8s/i' => 'keener',
        '/h1\+/i' => 'hummer',
        '/impress_l/i' => 'vertex',
        '/neo-x5/i' => 'minix',
        '/tab-97e-01/i' => 'reellex',
        '/vega/i' => 'advent',
        '/ xst2 /i' => 'fourgsystems',
        '/f10x/i' => 'nextway',
        '/adtab 7 lite/i' => 'adspec',
        '/neon-n1|wing-w2/i' => 'axgio',
        '/touareg8_3g/i' => 'accent',
        '/chagall/i' => 'pegatron',
        '/turbo x6/i' => 'turbopad',
        '/air a70/i' => 'roverpad',
        '/sp-6020 quasar/i' => 'woo',
        '/q10s/i' => 'wopad',
        '/uq785-m1bgv/i' => 'verico',
        '/t9666-1/i' => 'telsda',
        '/h7100/i' => 'feiteng',
        '/xda|cocoon/i' => 'o2',
        '/g009/i' => 'yxtel',
        '/picopad_s1/i' => 'axioo',
        '/adi_5s/i' => 'artel',
        '/norma 2/i' => 'keneksi',
        '/t880g/i' => 'etuline',
        '/tab-970/i' => 'prology',
        '/n90fhdrk|n90 dual core2|n101 dual core2/i' => 'yuandao',
        '/nova/i' => 'catsound',
        '/n820|a862w/i' => 'amoi',
        '/jay-tech|tpc-[a-z0-9]+/i' => 'jaytech',
        '/ g9 /i' => 'mastone',
        '/zt180/i' => 'zenithink',
        '/e1107/i' => 'yusu',
        '/p4d sirius/i' => 'nvsbl',
        '/ c2 /i' => 'zopo',
        '/smartpad/i' => 'einsundeins',
        '/i4901/i' => 'idea',
        '/gnet/i' => 'gnet',
        '/hive v 3g|hive iv 3g/i' => 'turbo-x',
        '/turkcell/i' => 'turkcell',
        '/is04/i' => 'kddi',
        '/be pro|paris|vienna|u007|future|power[_ ]3|tiger/i' => 'ulefone',
        '/sense golly/i' => 'ipro',
        '/sirius_qs/i' => 'vonino',
        '/dl 1803/i' => 'dl',
        '/s10q-3g/i' => 'smartbook',
        '/ s30 |gt100/i' => 'firefly',
        '/apollo|thor|mars pro/i' => 'vernee',
        '/itel|inote|1505-a02| a20 build/i' => 'itel',
        '/mi(tab|smart)/i' => 'wolder',
        '/909t| m13 /i' => 'mpie',
        '/z30/i' => 'magnus',
        '/uhappy|up720|up580|up520|up350|up320/i' => 'uhappy',
        '/m9c max/i' => 'bqeel',
        '/qt-10/i' => 'qmax',
        '/ilium l820/i' => 'lanix',
        '/s501m 3g|t700i_3g/i' => 'fourgood',
        '/ixion_es255|h135/i' => 'dexp',
        '/atl-21/i' => 'artizlee',
        '/w032i-c3|tr10rs1|tr10cd1/i' => 'intel',
        '/cyrus|cs[0-9]{2}/i' => 'cyrus',
        '/jy-/i' => 'jiayu',
        '/ m20 /i' => 'timmy',
        '/g708 oc/i' => 'colorfly',
        '/q880_xk/i' => 'tianji',
        '/c55/i' => 'ctroniq',
        '/l900/i' => 'landvo',
        '/ k5 /i' => 'komu',
        '/ x6 /i' => 'voto',
        '/VT[0-9]{3}/' => 'voto',
        '/ m71 /i' => 'eplutus',
        '/ (d10|y14) /i' => 'xgody',
        '/ifive mini 4s/i' => 'fnf',
        '/ arc /i' => 'kobo',
        '/m92d-3g/i' => 'sumvier',
        '/a88x/i' => 'alldaymall',
        '/bs1078/i' => 'yonestoptech',
        '/excellent8/i' => 'tomtec',
        '/ih-g101/i' => 'innohit',
        '/g900/i' => 'ippo',
        '/nimbus 80qb/i' => 'woxter',
        '/vkb011b|vkb004l/i' => 'fengxiang',
        '/trooper|tornado|thunder/i' => 'kazam',
        '/ n3 /i' => 'goophone',
        '/king 7/i' => 'pptv',
        '/(admire[_ ][^\/;]+|cinemax[^\/;)]+)(build|\) u)/i' => 'zen',
        '/1501_m02/i' => 'threesixty',
        '/t72/i' => 'oysters',
        '/ns-14t004|ns-p10a6100/i' => 'insignia',
        '/blaster 2/i' => 'justfive',
        '/strongphoneq4/i' => 'evolveo',
        '/shift[457]/i' => 'shift',
        '/k960|zh960/i' => 'jlinksz',
        '/i-call|elektra l|neon[79]/i' => 'ijoy',
        '/kodak|ektra/i' => 'kodak',
        '/kt107/i' => 'bdf',
        '/m52_red_note/i' => 'mlais',
        '/sunmicrosystems/i' => 'sun',
        '/coolpix s800c/i' => 'nikon',
        '/vsd220/i' => 'viewsonic',
        '/walton|primo[\- _]|walpad/i' => 'walton',
        '/x538/i' => 'sunsbell',
        '/sf1|s551/i' => 'obi',
        '/harrier tab/i' => 'ee',
        '/excite prime/i' => 'cloudfone',
        '/ z1 /i' => 'ninetology',
        '/ Presto /' => 'oplus',
        '/crono/i' => 'majestic',
        '/NS[0-9]{1,4}/' => 'nous',
        '/F1[0-9]/' => 'pulid',
        '/andromax|androtab|pd6d1j/i' => 'smartfren',
        '/ax5_duo/i' => 'maxx',
        '/ga10h/i' => 'gooweel',
        '/ypy_s450/i' => 'positivo',
        '/ph-1/i' => 'essential',
        '/tc970/i' => 'lepan',
        '/mfc[0-9]{3}[a-z]{2,}/i' => 'lexibook',
        '/vt75c/i' => 'videocon',
        '/rct[0-9]{4}/i' => 'rca-tablets',
        '/(centurion|gladiator| glory|luxury|sensuelle|victory)([ _\-]?[2-6])?[);\/ ]|surfing tab/i' => 'brondi',
        '/momo([0-9]|mini)/i' => 'ployer',
        '/ezee/i' => 'storex',
        '/cyclone [^\/;]+ build/i' => 'sumvision',
        '/ctc[0-9]{3}/i' => 'ctc',
        '/grv11/i' => 'gorila',
        '/unnecto|(u513|u61[1356]|u7[12]0|u-830|u90[35])[);\/ ]/i' => 'unnecto',
        '/q101-4g|4g-universal version/i' => 'voyo',
        '/robin/i' => 'nextbit',
        '/bitel[ _-][^\/;]+ build|b8604|b9501/i' => 'bitel',
        '/x96mini/i' => 'edal',
        '/mxqpro/i' => 'bomix',
        '/t5524/i' => 'smartron',
        '/unonu/i' => 'unonu',
        '/cobalt_/i' => 'cobalt',
        '/(mpm|midm)[_-]/i' => 'miray',
        '/runbo/i' => 'runbo',
        '/fly4/i' => 'vivax',
        '/elitedual/i' => 'swipe',
        '/kata-/i' => 'kata',
        '/I5/' => 'sop',
        '/i5/' => 'vsun',
        '/KIN\.(One|Two)|ZuneHD|Windows NT 6\.(2|3).*ARM;/' => 'microsoft',
    ];

    /**
     * @var \BrowserDetector\Loader\DeviceLoaderFactory
     */
    private $loaderFactory;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->loaderFactory = new DeviceLoaderFactory($logger);
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $loaderFactory = $this->loaderFactory;

        foreach ($this->factories as $rule => $company) {
            try {
                if (preg_match($rule, $useragent)) {
                    $loader = $loaderFactory($company, 'mobile');

                    return $loader($useragent);
                }
            } catch (\Throwable $e) {
                throw new \InvalidArgumentException(sprintf('An error occured while matching rule "%s"', $rule), 0, $e);
            }
        }

        $loader = $loaderFactory('unknown', 'mobile');

        return $loader($useragent);
    }
}
