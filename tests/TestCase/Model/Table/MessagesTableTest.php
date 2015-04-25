<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\MessagesTable;

/**
 * GintonicCMS\Model\Table\MessagesTable Test Case
 */
class MessagesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    //public $fixtures = [
    //    'Messages' => 'plugin.gintonic_c_m_s.messages',
    //    'Sender' => 'plugin.gintonic_c_m_s.sender',
    //    'Files' => 'plugin.gintonic_c_m_s.files',
    //    'Users' => 'plugin.gintonic_c_m_s.users',
    //    'Albums' => 'plugin.gintonic_c_m_s.albums',
    //    'Threads' => 'plugin.gintonic_c_m_s.threads',
    //    'MessageReadStatus' => 'plugin.gintonic_c_m_s.message_read_status'
    //];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Messages') ? [] : ['className' => 'GintonicCMS\Model\Table\MessagesTable'];
        $this->Messages = TableRegistry::get('Messages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Messages);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test setRead method
     *
     * @return void
     */
    public function testSetRead()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sentMessage method
     *
     * @return void
     */
    public function testSentMessage()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sentGroupMessage method
     *
     * @return void
     */
    public function testSentGroupMessage()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test changeMessageStatus method
     *
     * @return void
     */
    public function testChangeMessageStatus()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
