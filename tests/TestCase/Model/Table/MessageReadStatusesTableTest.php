<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\MessageReadStatusesTable;

/**
 * GintonicCMS\Model\Table\MessageReadStatusesTable Test Case
 */
class MessageReadStatusesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    //public $fixtures = [
    //    'MessageReadStatuses' => 'plugin.gintonic_c_m_s.message_read_statuses',
    //    'Messages' => 'plugin.gintonic_c_m_s.messages'
    //];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MessageReadStatuses') ? [] : ['className' => 'GintonicCMS\Model\Table\MessageReadStatusesTable'];
        $this->MessageReadStatuses = TableRegistry::get('MessageReadStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MessageReadStatuses);

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
}
