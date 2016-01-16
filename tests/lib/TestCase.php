<?php
/**
 * Project: cDeep
 * File: TestCase.php
 * User: fso
 * Date: 26.11.2014
 * Time: 19:07
 * Description:
 */

namespace Deep;

/**
 * Class TestCase
 * @package Deep
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Clean up after test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
