<?php
namespace GintonicCMS\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use GintonicCMS\View\Helper\UnitConversionHelper;

/**
 * GintonicCMS\View\Helper\UnitConversionHelper Test Case
 */
class UnitConversionHelperTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->UnitConversion = new UnitConversionHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UnitConversion);

        parent::tearDown();
    }

    /**
     * Test convertLength method
     *
     * @return void
     */
    public function testConvertLength()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test convertMass method
     *
     * @return void
     */
    public function testConvertMass()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
