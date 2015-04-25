<?php
namespace GintonicCMS\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use GintonicCMS\View\Helper\UserHelper;

/**
 * GintonicCMS\View\Helper\UserHelper Test Case
 */
class UserHelperTest extends TestCase
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
        $this->User = new UserHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->User);

        parent::tearDown();
    }

    /**
     * Test avatar method
     *
     * @return void
     */
    public function testAvatar()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
