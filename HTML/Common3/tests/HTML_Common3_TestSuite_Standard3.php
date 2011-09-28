<?php
declare(ENCODING = 'utf-8');
namespace Test;

// Call HTML_Common3_TestSuite_Standard::main() if this source file is executed directly.
if (!defined("PHPUnit2_MAIN_METHOD")) {
    define("PHPUnit2_MAIN_METHOD", "Standard::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

// You may remove the following line when all tests have been implemented.
require_once "PHPUnit/Framework/IncompleteTestError.php";

require_once "HTML/Common3.php";
require_once "HTML/Common3/Root/Html.php";
require_once "HTML/Common3/Root/Div.php";

/**
 * A non-abstract subclass of HTML_Common3 
 *
 * HTML_Common3 cannot be instantiated, we need to (sort of) implement that.
 */
class Concrete extends \HTML\Common3
{
    protected $posAttributes = array(
        '#all'    => array (
            'style',
            'height',
            'multiple',
            'width',
            'class',
            'checked',
            'nowrap',
            'selected',
            'onclick',
            'readonly',
            'id',
            'name'
        )
    );
    
    protected $posElements = array(
        '#all'    => array (
            'html'
        )
    );
    
    /**
     * List of attributes to which will be announced via 
     * {@link onAttributeChange()} method rather than performed by
     * HTML_Common3 class itself
     *
     * contains all required attributes
     *
     * @var      array
     * @see      onAttributeChange()
     * @see      getWatchedAttributes()
     * @access   protected
     * @readonly
     */
    protected $watchedAttributes = array('readonly', 'uppercase');

    protected $attributes = array(
        'readonly'  => 'this attribute is readonly',
        'uppercase' => 'VALUE OF THIS IS ALWAYS UPPERCASE'
    );
    
    public function init()
    {
        parent::init();
        
        $this->allAttributes['readonly'] = array(
            'type'        => '#CNAME',
            'sc'        => false,
            'replace'    => null,
            'space'        => true
        );
        
        $this->allAttributes['uppercase'] = array(
            'type'        => '#CNAME',
            'sc'        => false,
            'replace'    => null,
            'space'        => true
        );
        
        return $this;
    }
    
    protected function onAttributeChange($name, $value = null)
    {
        if ('readonly' == $name) {
            return;
        }
        if ('uppercase' == $name) {
            if (null === $value) {
                unset($this->attributes[$name]);
            } else {
                $this->attributes[$name] = strtoupper($value);
            }
        }
    }
}

/**
 * Test class for HTML_Common3.
 * Generated by PHPUnit2_Util_Skeleton on 2008-08-03 at 15:03:13.
 */
class Standard extends \PHPUnit_Framework_TestCase {
    /**
     * @var    HTML_Common3
     * @access protected
     */
    protected $object;
    
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new \PHPUnit_Framework_TestSuite("HTML_Common3_TestSuite_Standard");
        $result = \PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
        $this->object = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    }

    public function testConstructorIgnoresDefaultAttributesIfUnknown()
    {
        $msg = null;
        try{
            $obj = new \HTML\Common3\Root\Html(array('foo' => 'bar'));
            $this->assertSame(array('xml:lang' => 'en'), $obj->getAttributes()); //empty array
            $this->assertType('array', $obj->getAttributes()); 
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg); //no error
        
        $msg = null;
        try{
            $obj = new \HTML\Common3\Root\Html(array('foo' => 'bar', 'xml:lang' => 'de'));
            $this->assertSame(array('xml:lang'=>'de'), $obj->getAttributes()); //empty array
            $this->assertType('array', $obj->getAttributes()); 
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg); //no error
    }

    public function testConstructorSetsDefaultAttributes()
    {
        $obj = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
        $this->assertSame(array(
            'xml:lang'           => 'en',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemalocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd'
        ), $obj->getAttributes());
        
        $obj = new \HTML\Common3\Root\Html(array('style' => 'height:20px;'));
        $this->assertSame(array(
            'xml:lang' => 'en'
        ), $obj->getAttributes());
    }

    public function testApiVersion()
    {
        $version = \HTML\Common3::apiVersion();
        $this->assertSame('3.0.0', $version);
        $this->assertType('string', $version);
    }

    public function testGetApiVersion()
    {
        $obj = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
        $version = $obj->getApiVersion();
        $this->assertSame('3.0.0', $version);
        $this->assertType('string', $version);
    }

    public function testGetElementName()
    {
        $obj = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
        $this->assertSame('html', $obj->getElementName());
    }

    public function testUnknownAttributeIsNull()
    {
        $obj = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
        $this->assertNull($obj->getAttribute('foobar'));
    }

    public function testAttributeNamesAreLowercased()
    {
        $obj = new \HTML\Common3\Root\Html();
        
        $msg = null;
        try{
            $obj->setAttributes(array('STYLE' => 'height:20px;'));
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg);
        
        $msg = null;
        try{
            $obj->setAttribute('Multiple', 'bar');
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg);
        
        $obj->mergeAttributes(array('HeIGHt' => '100%'));
        
        $this->assertNotSame('bar', $obj->getAttribute('MuLtIpLe'));
        //$this->assertSame(null, $obj->getAttribute('MuLtIpLe'));
        
        $this->assertSame(
            array(), 
            $obj->getAttributes()
        );
    }

    public function testAttributeValuesAreStrings()
    {
        $obj = new \HTML\Common3\Root\Html();
        
        $msg = null;
        try{
            $obj->setAttributes(array('onclick' => null, 'width' => 10));
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg);
        
        $msg = null;
        try{
            $obj->setAttribute('height', 2.5);
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg);
        
        $obj->mergeAttributes(array('multiple' => 42));
        foreach ($obj->getAttributes() as $attribute) {
            $this->assertType('string', $attribute);
        }
    }

    public function testUnknownOptionIsNull()
    {
        $obj = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
        $this->assertNull($obj->getOption('foobar'));
    }

    public function testAnyOptionAllowed()
    {
        $obj = new \HTML\Common3\Root\Html();
        $obj->setOption('foobar', 'baz');
        $this->assertSame('baz', $obj->getOption('foobar'));
        
        $obj->setOption('foobar2', 2);
        $this->assertSame(2, $obj->getOption('foobar2'));
        
        $obj->setOption('foobar3', 2.5);
        $this->assertSame(2.5, $obj->getOption('foobar3'));
        
        $obj->setOption('foobar4', null);
        $this->assertSame(null, $obj->getOption('foobar4'));
    }

    public function testNotSetAttributeIsNull()
    {
        $obj = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
        $this->assertNull($obj->getAttribute('id'));
    }

    public function testGetWatchedAttributes()
    {
        $obj = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
        $this->assertSame(array(), $obj->getWatchedAttributes());
    }

    public function testGetOption()
    {
        $this->assertSame(null, $this->object->getOption('foobar'));
        $this->assertSame('iso-8859-1', $this->object->getOption('charset'));
        $this->assertSame('    ', $this->object->getOption('indent'));
        $this->assertSame(PHP_EOL, $this->object->getOption('linebreak'));
        $this->assertSame(0, $this->object->getOption('level'));
        $this->assertSame('', $this->object->getOption('comment'));
        $this->assertSame(null, $this->object->getOption('browser'));
        //$this->assertSame(null, $this->object->getOption('i18n'));
        $this->assertSame('application/xhtml+xml', $this->object->getOption('mime'));
        $this->assertSame(false, $this->object->getOption('cache'));
    }

    public function testGetEmpty()
    {
        $obj = new \HTML\Common3\Root\Html(array(
            'doctype'            => 'XHTML 1.1',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd',
            'cache'              => true
        ));
        $this->assertSame(false, $obj->getEmpty());
    }

    public function testGetIsRootElement()
    {
        $this->assertSame(true, $this->object->getIsRootElement());
    }

    public function testGetElements()
    {
        $this->assertSame(2, count($this->object->getElements()));
    }

    public function testGetDisabled()
    {
        $this->assertSame(false, $this->object->getDisabled());
    }

    public function testGetValue()
    {
        $this->assertSame('', $this->object->getValue());
    }

    public function testGetCache()
    {
        $this->assertSame(false, $this->object->getCache());
        
        $obj = new \HTML\Common3\Root\Html();
        $obj->setCache(true);
        $this->assertSame('public', $obj->getCache());
        
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame(false, $obj->getCache());
    }
    
    public function testGetMime()
    {
        $this->assertSame('application/xhtml+xml', $this->object->getMime());
        
        $obj = new \HTML\Common3\Root\Html(array('doctype' => 'XHTML 1.0'));
        $this->assertSame('application/xhtml+xml', $obj->getMime());
        
        $obj = new \HTML\Common3\Root\Html();
        $obj->setMime('application/pdf');
        $this->assertSame('application/pdf', $obj->getMime());
    }
    
    public function testGetMimeEncoding()
    {
        $this->assertSame('application/xhtml+xml', $this->object->getMimeEncoding());
        
        $obj = new \HTML\Common3\Root\Html(array('doctype' => 'XHTML 1.0'));
        $this->assertSame('application/xhtml+xml', $obj->getMimeEncoding());
        
        $obj = new \HTML\Common3\Root\Html();
        $obj->setMimeEncoding('application/pdf');
        $this->assertSame('application/pdf', $obj->getMimeEncoding());
    }
    
    public function testGetType()
    {
        $this->assertSame('html', $this->object->getType());
    }
    
    public function testDefaultIndentLevelIsZero()
    {
        $this->assertSame(0, $this->object->getIndentLevel());
    }

    public function testIndentLevelIsAllwaysZeroForHtml()
    {
        $obj = new \HTML\Common3\Root\Html();
        $obj->setIndentLevel(-1);
        $this->assertSame(0, $obj->getIndentLevel());
        $obj->setIndentLevel(1);
        $this->assertSame(0, $obj->getIndentLevel());
    }

    public function testDefaultCommentIsEmptyString()
    {
        $this->assertSame('', $this->object->getComment());
    }

    public function testCommentIsString()
    {
        $obj = new \HTML\Common3\Root\Html(array('comment'=>'Hallo'));
        $this->assertSame('', $obj->getComment());
        $obj->setComment('Hallo');
        $this->assertSame('Hallo', $obj->getComment());
    }

    public function testAttributesAsStringAccepted()
    {
        $obj = new \HTML\Common3\Root\Html('multiple  style="height: 2em;" class=\'foo\' width=100% ');
        $this->assertSame(array('xml:lang' => 'en'), $obj->getAttributes());
    }

    public function testNonXhtmlAttributesTransformed()
    {
        $obj = new \HTML\Common3\Root\Html(array('multiple'));
        $obj->setAttribute('selected');
        $obj->mergeAttributes('checked nowrap');
        $this->assertSame(
            array('xml:lang'=>'en'), //array('multiple' => 'multiple', 'selected' => 'selected', 'checked' => 'checked', 'nowrap' => 'nowrap'),
            $obj->getAttributes()
        );
    }

    public function testWellFormedXhtmlGenerated()
    {
        $obj = new \HTML\Common3\Root\Html(array('onclick' => 'bar&"baz"', 'style' => 'xyz\'zy'));
        $this->assertSame(
            ' xml:lang="en"',//' onclick="bar&amp;&quot;baz&quot;" style="xyz&#039;zy"',
            $obj->getAttributes(true)
        );
    }
    
    public function testCanWatchAttributes()
    {
        $obj = new \HTML\Common3\Root\Html();
        //$obj->setAddToDtd(true);
        
        $msg = null;
        try{
            $obj->setAttributes(array('readonly' => 'something', 'uppercase' => 'new value', 'foo' => 'bar'));
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg);
        
        $obj->mergeAttributes(array('readonly' => 'something', 'uppercase' => 'other value', 'foo' => 'baz', 'onclick' => 'abc();'));
        $this->assertSame(
            array(), //array('onclick' => 'abc();'),
            $obj->getAttributes()
        );
        
        $obj->setAttribute('readonly', 'something else');
        $msg = null;
        try{
            $obj->setAttribute('uppercase', 'yet another value');
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg);
        
        $msg = null;
        try{
            $obj->setAttribute('foo', 'quux');
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg);
        
        $this->assertSame(
            array(), //array('onclick' => 'abc();'),
            $obj->getAttributes()
        );

        $obj->removeAttribute('readonly');
        $obj->removeAttribute('uppercase');
        $obj->removeAttribute('foo');
        //var_dump($obj->getAttributes());
        
        $this->assertSame(
            array(), //array('onclick' => 'abc();'),
            $obj->getAttributes()
        );
    }

    public function testFluentInterfaces()
    {
        $obj = new \HTML\Common3\Root\Html();

        $this->assertSame($obj, $obj->setAttributes(array('foo' => 'foo value')));
        $this->assertSame($obj, $obj->mergeAttributes(array('bar' => 'bar value')));
        $msg = null;
        
        try{
            $this->assertSame($obj, $obj->setAttribute('baz', 'baz value'));
        } catch(\HTML\Common3\Exception $e) {
            $msg = $e->getFinalMessage();
        }
        $this->assertNull($msg);
        
        $this->assertSame($obj, $obj->removeAttribute('bar'));
        $this->assertSame($obj, $obj->setComment('A comment'));
        $this->assertSame($obj, $obj->setIndentLevel(3));
    }
    
    public function testCreateXHML11WithSchemaLocation()
    {
        $out      = $this->object->toHtml(0, false, true);
        $shouldBe = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!-- type:html - begin -->
<html xml:lang="en" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd" xmlns="http://www.w3.org/1999/xhtml">
    <!-- type:head - begin -->
    <head xml:lang="en">
        <title xml:lang="en"></title>
        <meta content="application/xhtml+xml; charset=iso-8859-1" http-equiv="content-type" xml:lang="en" />
    </head>
    <!-- type:head - end -->
    <body xml:lang="en">
    <!-- no Content to show -->
    </body>
</html>
<!-- type:html - end -->
';
        $this->assertSame($shouldBe, $out);
    }
    
    public function testGetAttribute()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame(null, $obj->getAttribute('foobar'));
        $this->assertSame(null, $obj->getAttribute('id'));
    }

    public function testGetElementEmpty()
    {
        $this->assertSame(false, $this->object->getElementEmpty());
    }

    public function testGetParent()
    {
        $this->assertSame(null, $this->object->getParent());
    }

    public function testGetHtml()
    {
        $this->assertSame(null, $this->object->getHtml());
    }

    public function testGetDoctype()
    {
        $this->assertSame(array('type'=>'xhtml', 'version'=>'1.1', 'variant'=>'strict'), $this->object->getDoctype());
    }

    public function testGetPosElements()
    {
        $this->assertSame(array('head', 'body'), $this->object->getPosElements());
    }

    public function testGetForbidElements()
    {
        $this->assertSame(array(), $this->object->getForbidElements());
    }

    public function testGetPosAttributes()
    {
        $this->assertSame(array (
            'dir',
            'xml:lang',
            'xmlns',
            'xmlns:xsi',            //xsi namespace
            'xsi:schemalocation'
        ), $this->object->getPosAttributes());
    }

    public function testGetIDs()
    {
        $this->assertSame(array(), $this->object->getIDs());
    }

    public function testGetAddToDtd()
    {
        $this->assertSame(false, $this->object->getAddToDtd());
    }

    public function testGetLang()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame(null, $obj->getLang());
        
        $obj->setLang('en');
        $this->assertSame('en', $obj->getLang());
        
        $obj->setLang('de');
        $this->assertSame('de', $obj->getLang());
        
        $obj->setLang('fr');
        $this->assertSame('fr', $obj->getLang());
        
        $obj->setLang('ru');
        $this->assertSame('ru', $obj->getLang());
    }

    public function testGetAttributes()
    {
        $this->assertSame(array(
            'xml:lang'           => 'en',
            'xmlns:xsi'          => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemalocation' => 'http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd'
        ), $this->object->getAttributes());
    }

    public function testGetId()
    {
        $obj = new \HTML\Common3\Root\Div();
        $this->assertNull($obj->getId());
        
        $obj->setAddToDtd(true);
        
        $obj->setId('abc');
        $this->assertSame('abc', $obj->getId());
        $this->assertNull($obj->getName());
        
        $obj = new \HTML\Common3\Root\Div(array('id'=>'xyz'));
        $this->assertSame('xyz', $obj->getId());
        $this->assertNull($obj->getName());
    }

    public function testGetName()
    {
        $obj = new \HTML\Common3\Root\Div();
        $this->assertNull($obj->getName());
        
        $obj->setAddToDtd(true);
        
        $obj->setName('abc');
        //$this->assertNotSame('abc', $obj->getId());
        $this->assertNull($obj->getName());
        
        $obj = new \HTML\Common3\Root\Div(array('name'=>'xyz'));
        //$this->assertNotSame('xyz', $obj->getId());
        $this->assertNull($obj->getName());
    }

    public function testGetIndentLevel()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame(0, $obj->getIndentLevel());
    }

    public function testLevelIsAllwaysZero()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame(0, $obj->getIndentLevel());
        
        $obj->setIndentLevel(4);
        $this->assertSame(0, $obj->getIndentLevel());
    }

    public function testGetTab()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame('    ', $obj->getTab());
        
        $obj->setTab("\t");
        $this->assertSame("\t", $obj->getTab());
    }

    public function testGetLineEnd()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame(PHP_EOL, $obj->getLineEnd());
        
        $obj->setLineEnd("\12\15");
        $this->assertSame("\12\15", $obj->getLineEnd());
    }

    public function testGetComment()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame('', $obj->getComment());
        
        $obj->setComment('Test Comment');
        $this->assertSame('Test Comment', $obj->getComment());
    }

    public function testCharset()
    {
        $obj = new \HTML\Common3\Root\Html();
        
        $this->assertSame('iso-8859-1', $obj->charset());
        $this->assertSame('iso-8859-1', $obj->charset('utf-8'));
        $this->assertSame('utf-8', $obj->charset());
    }

    public function testGetCharset()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame('iso-8859-1', $obj->getCharset());
        
        $obj->setCharset('utf-8');
        $this->assertSame('utf-8', $obj->getCharset());
        
        $obj->setCharset('iso-8859-1');
        $this->assertSame('iso-8859-1', $obj->getCharset());
    }

    public function testIsEmpty()
    {
        $this->assertSame(false, $this->object->isEmpty());
    }

    public function testElementsMayBeDisabledOrEnabled()
    {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame(true, $obj->isEnabled());
        
        $obj = new \HTML\Common3\Root\Div();
        $obj->disable();
        $this->assertSame(false, $obj->isEnabled());
        
        $obj->enable();
        $this->assertSame(true, $obj->isEnabled());
    }

    public function testGetChildren()
    {
        $this->assertSame(2, count($this->object->getChildren()));
        $children = $this->object->getChildren();
        
        $this->assertType('object', $children[0]);
        $this->assertType('object', $children[1]);
    }

    public function testCount()
    {
        //$this->assertSame(0, $this->object->count());
        $this->assertSame(2, $this->object->count());
    }

    public function testExistsAttribute() {
        $obj = new \HTML\Common3\Root\Html();
        $this->assertSame(false, $obj->existsAttribute('id'));
        
        $obj->setId('abc');
        $this->assertSame(false, $obj->existsAttribute('id'));
    }

    public function testGetElementById() {
        $obj = new \HTML\Common3\Root\Html();
        $obj->setId('abc');
        
        $this->assertNull($obj->getElementById('abc'));
        //$this->assertType('object', $obj->getElementById('abc'));
        
        $this->assertNull($obj->getElementById('xyz'));
    }

    public function testGetElementsByName() {
        $obj = new \HTML\Common3\Root\Html();
        $obj->setName('abc');
        
        $this->assertNotNull($obj->getElementsByName('abc'));
        $this->assertType('array', $obj->getElementsByName('abc'));
        
        $this->assertSame(array(), $obj->getElementsByName('xyz'));
    }

    public function testGetRoot() {
        $this->assertType('object', $this->object->getRoot());
        $this->assertSame($this->object, $this->object->getRoot());
    }

    public function testIsRoot() {
        $this->assertSame(true, $this->object->isRoot());
        $this->assertSame(true, $this->object->isRoot());
    }

    public function testAllowToExtendDoTypeDefinition() {
        $this->assertSame(false, $this->object->getAddToDtd());
        
        $this->object->setAddToDtd(true);
        $this->assertSame(true, $this->object->getAddToDtd());
        
        $this->object->setAddToDtd(false);
        $this->assertSame(false, $this->object->getAddToDtd());
        
        $this->object->setAddToDtd(true);
        /*
         @see http://www.alistapart.com/articles/customdtd/
        
        <!DOCTYPE html PUBLIC
        "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
        [
          <!ATTLIST textarea maxlength CDATA #IMPLIED>
          <!ATTLIST textarea required (true|false) #IMPLIED>
          <!ATTLIST input required (true|false) #IMPLIED>
          <!ATTLIST select required (true|false) #IMPLIED>
        ]>
        */
        $this->object->addDtdAttribute('textarea', 'maxlength', 'CDATA', '#IMPLIED');
        $this->object->addDtdAttribute('textarea', 'required', '(true|false)', '#REQUIRED');
        $this->object->addDtdAttribute('input', 'required', '(true|false)', '#IMPLIED');
        $this->object->addDtdAttribute('select', 'required', '(true|false)', '#IMPLIED');

        $shouldBe = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"
    [
    <!ATTLIST textarea
              maxlength CDATA #IMPLIED
              required (true|false) #REQUIRED
    >
    <!ATTLIST input
              required (true|false) #IMPLIED
    >
    <!ATTLIST select
              required (true|false) #IMPLIED
    >
    ]>
<html xml:lang="en" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd" xmlns="http://www.w3.org/1999/xhtml">
    <head xml:lang="en">
        <title xml:lang="en"></title>
        <meta content="application/xhtml+xml; charset=iso-8859-1" http-equiv="content-type" xml:lang="en" />
    </head>
    <body xml:lang="en">
    <!-- no Content to show -->
    </body>
</html>
';
        $output   = $this->object->toHtml();
        $this->assertSame($shouldBe, $output);
        
        $this->object->unsetDtdAttribute('textarea', 'required');

        $shouldBe = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"
    [
    <!ATTLIST textarea
              maxlength CDATA #IMPLIED
    >
    <!ATTLIST input
              required (true|false) #IMPLIED
    >
    <!ATTLIST select
              required (true|false) #IMPLIED
    >
    ]>
<html xml:lang="en" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd" xmlns="http://www.w3.org/1999/xhtml">
    <head xml:lang="en">
        <title xml:lang="en"></title>
        <meta content="application/xhtml+xml; charset=iso-8859-1" http-equiv="content-type" xml:lang="en" />
    </head>
    <body xml:lang="en">
    <!-- no Content to show -->
    </body>
</html>
';
        $output   = $this->object->toHtml();
        //var_dump($shouldBe);
        //var_dump($output);
        $this->assertSame($shouldBe, $output);
    }
    
    public function testEnableOrDisableXmlProlog() {
        $this->object->enableXmlProlog();
        
        $shouldBe = '<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xml:lang="en" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd" xmlns="http://www.w3.org/1999/xhtml">
    <head xml:lang="en">
        <title xml:lang="en"></title>
        <meta content="application/xhtml+xml; charset=iso-8859-1" http-equiv="content-type" xml:lang="en" />
    </head>
    <body xml:lang="en">
    <!-- no Content to show -->
    </body>
</html>
';
        $output   = $this->object->toHtml();
        //var_dump($shouldBe);
        //var_dump($output);
        $this->assertSame($shouldBe, $output);
        
        $this->object->disableXmlProlog();
        
        $shouldBe = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xml:lang="en" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd" xmlns="http://www.w3.org/1999/xhtml">
    <head xml:lang="en">
        <title xml:lang="en"></title>
        <meta content="application/xhtml+xml; charset=iso-8859-1" http-equiv="content-type" xml:lang="en" />
    </head>
    <body xml:lang="en">
    <!-- no Content to show -->
    </body>
</html>
';
        $output   = $this->object->toHtml();
        //var_dump($shouldBe);
        //var_dump($output);
        $this->assertSame($shouldBe, $output);
    }
}

// Call HTML_Common3_TestSuite_Standard::main() if this source file is executed directly.
if (PHPUnit2_MAIN_METHOD == "Standard::main") {
    Standard::main();
}
?>