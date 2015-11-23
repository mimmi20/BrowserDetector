<?php
/**
 * Copyright (c) 1998-2014 Browser Capabilities Project
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the LICENSE file distributed with this package.
 *
 * @category   BrowscapTest
 * @package    Test
 * @copyright  1998-2014 Browser Capabilities Project
 * @license    MIT
 */

namespace BrowserDetectorTest;

use Browscap\Data\PropertyHolder;
use BrowserDetector\BrowserDetector;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use phpbrowscap\Browscap;
use Browscap\Generator\BuildGenerator;
use Browscap\Helper\CollectionCreator;
use Browscap\Writer\Factory\PhpWriterFactory;
use WurflCache\Adapter\File;

/**
 * Class UserAgentsTest
 *
 * @category   BrowscapTest
 * @package    Test
 * @author     James Titcumb <james@asgrim.com>
 * @group      useragenttest
 */
class UserAgentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\BrowserDetector
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $logger = new Logger('browser-detector-tests');
        $logger->pushHandler(new NullHandler());

        $cache = new File(array(File::DIR => 'tests/cache/'));
        $this->object = new BrowserDetector($cache, $logger);
    }

    /**
     * @return array[]
     */
    public function userAgentDataProvider()
    {
        static $data = array();

        if (count($data)) {
            return $data;
        }

        $checks          = array();
        $sourceDirectory = __DIR__ . '/data/issues/';

        $iterator = new \RecursiveDirectoryIterator($sourceDirectory);

        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile() || $file->getExtension() != 'php') {
                continue;
            }

            $tests = require_once $file->getPathname();

            foreach ($tests as $key => $test) {
                if (isset($data[$key])) {
                    throw new \RuntimeException('Test data is duplicated for key "' . $key . '"');
                }

                if (isset($checks[$test[0]])) {
                    throw new \RuntimeException(
                        'UA "' . $test[0] . '" added more than once, now for key "' . $key . '", before for key "'
                        . $checks[$test[0]] . '"'
                    );
                }

                $data[$key]       = $test;
                $checks[$test[0]] = $key;
            }
        }

        return $data;
    }

    /**
     * @dataProvider userAgentDataProvider
     * @coversNothing
     *
     * @param string $userAgent
     * @param array  $expectedProperties
     *
     * @throws \Exception
     * @group  integration
     * @group  useragenttest
     */
    public function testUserAgents($userAgent, $expectedProperties)
    {
        if (!is_array($expectedProperties) || !count($expectedProperties)) {
            self::markTestSkipped('Could not run test - no properties were defined to test');
        }

        $result = $this->object->getBrowser($userAgent);

        self::assertSame(
            $expectedProperties['Browser'],
            $result->getBrowser()->getName(),
            'Expected actual "mobile_browser" to be "' . $expectedProperties['Browser']
            . '" (was "' . $result->getCapability('mobile_browser', false) . '")'
        );

        self::assertSame(
            $expectedProperties['Browser_Type'],
            $result->getBrowser()->getBrowserType(),
            'Expected actual "mobile_browser" to be "' . $expectedProperties['Browser_Type']
            . '" (was "' . $result->getBrowser()->getBrowserType() . '")'
        );

        self::assertSame(
            $expectedProperties['Browser_Bits'],
            $result->getBrowser()->detectBits(),
            'Expected actual "mobile_browser" to be "' . $expectedProperties['Browser_Bits']
            . '" (was "' . $result->getBrowser()->detectBits() . '")'
        );
    }
}
