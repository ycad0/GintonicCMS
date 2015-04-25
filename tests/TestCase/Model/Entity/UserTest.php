<?php
namespace GintonicCMS\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Entity\User;

/**
 * GintonicCMS\Model\Entity\User Test Case
 */
class UserTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->User = new User();
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
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
