<?php
/**
 * Project: cDeep
 * File: AutoloadTest.php
 * User: fso
 * Date: 25.11.2014
 * Time: 15:37
 * Description:
 */

namespace Deep;


/**
 * Class AutoloadTest
 * @package Deep
 */
class AutoloadTest extends TestCase
{

    /**
     * @var Autoload
     */
    private $Autoload = null;

    /**
     * @before
     */
    protected function prepareLoader()
    {
        $this->Autoload = new Autoload([__DIR__ . '/../../stubs/']);
        $this->Autoload->addPostLoadHandler([$this, 'handler']);
    }

    /**
     * @after
     */
    protected function unregisterLoader()
    {
        $this->Autoload->unregister();
    }

    /**
     * @annotation Local handler for testSetPostLoadHandler
     * @param string $Class
     */
    public function handler($Class)
    {
        if(property_exists($Class, 'autoConfig')) {
            $Class::$autoConfig = ['Class' => 'Dummy'];
        }
    }

    public function testAutoload()
    {
        $this->assertTrue($this->Autoload instanceof Autoload);
    }

    /**
     * @annotation Set Autoloader Handler for post-load initialization
     */
    public function testResolveClass()
    {
        $this->assertTrue(\Dummy::$isLoaded);
    }

    /**
     * @annotation Set Autoloader Handler for post-load initialization
     * @depends testResolveClass
     */
    public function testAddPostLoadHandler()
    {
        $this->assertEquals(['Class' => 'Dummy'], \Dummy::$autoConfig);
    }

    public function testAddClassPath()
    {
        $Path = __DIR__ . '/../../stubs2/';
        $this->assertContains($Path, $this->Autoload->addClassPath($Path));
    }

}
