<?php
namespace GintonicCMS\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Entity\MessageReadStatus;

/**
 * GintonicCMS\Model\Entity\MessageReadStatus Test Case
 */
class MessageReadStatusTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->MessageReadStatus = new MessageReadStatus();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MessageReadStatus);

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
