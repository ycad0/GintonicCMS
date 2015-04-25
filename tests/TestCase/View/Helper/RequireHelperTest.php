<?php
namespace GintonicCMS\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use GintonicCMS\View\Helper\RequireHelper;

/**
 * GintonicCMS\View\Helper\RequireHelper Test Case
 */
class RequireHelperTest extends TestCase
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
        $this->Require = new RequireHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Require);

        parent::tearDown();
    }

    /**
     * Test load method
     *
     * @return void
     */
    public function testLoad()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test req method
     *
     * @return void
     */
    public function testReq()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test ajaxReq method
     *
     * @return void
     */
    public function testAjaxReq()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test basemodule method
     *
     * @return void
     */
    public function testBasemodule()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
