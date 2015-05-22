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
     * Test sendRecovery method
     *
     * @return void
     */
    public function testSendRecovery()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendSignup method
     *
     * @return void
     */
    public function testSendSignup()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendVerification method
     *
     * @return void
     */
    public function testSendVerification()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test updateToken method
     *
     * @return void
     */
    public function testUpdateToken()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test verify method
     *
     * @return void
     */
    public function testVerify()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
