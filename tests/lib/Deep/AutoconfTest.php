<?php
/**
 * Project: cDeep
 * File: AutoconfTest.php
 * User: fso
 * Date: 25.11.2014
 * Time: 14:45
 * Description:
 */

namespace Deep;


/**
 * Class AutoconfTest
 * @package Deep
 */
class AutoconfTest extends TestCase
{
    /**
     * @var Autoconf
     */
    private $Autoconf = null;

    /**
     * @before
     */
    public function getAutoconf()
    {
        $this->Autoconf = new Autoconf([
            APP_ROOT . 'etc/',
        ]);
    }

    /**
     * @annotation Ini-file loading etc/Autoconf.ini
     * */
    public function testReadConfig()
    {
        $Expect = ['Test' => ['Option' => 1]];
        $this->assertEquals($Expect, $this->Autoconf->readConfig('Deep/Autoconf'));

        $this->assertEquals($Expect, $this->Autoconf->readConfig('Deep/Autoconf'));

        $this->assertEquals([], $this->Autoconf->readConfig('Notexists'));
    }

    /**
     * @annotation adding self::$Config configuration array
     * */
    public function testConfigureObject()
    {
        $Expect = ['Test' => ['Option' => 1]];
        $this->assertEquals($Expect, $this->Autoconf->configureObject('\Deep\Autoconf'));
        $this->assertEquals($Expect, Autoconf::$autoConfig);

        $this->assertEquals([], $this->Autoconf->configureObject('\Baz2'));

	require_once(APP_ROOT . 'stubs/Foo.php');
	$fooInstance = new \Foo();

        $Expect = ['Test2' => ['Option2' => 2]];
        $this->assertEquals($Expect, $this->Autoconf->configureObject('\Foo'));

        $Expect = ['Test2' => ['Option2' => 2], 'Test3' => 3];
	$this->invokeMethod($fooInstance, 'extendConfig', [['Test3' => 3]]);
        $this->assertEquals($Expect, \Foo::$autoConfig);

    }
}
