<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\ThreadParticipantsTable;

/**
 * GintonicCMS\Model\Table\ThreadParticipantsTable Test Case
 */
class ThreadParticipantsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'ThreadParticipants' => 'plugin.gintonic_c_m_s.thread_participants',
        'Threads' => 'plugin.gintonic_c_m_s.threads',
        'Users' => 'plugin.gintonic_c_m_s.users',
        'Files' => 'plugin.gintonic_c_m_s.files',
        'Albums' => 'plugin.gintonic_c_m_s.albums'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ThreadParticipants') ? [] : ['className' => 'GintonicCMS\Model\Table\ThreadParticipantsTable'];
        $this->ThreadParticipants = TableRegistry::get('ThreadParticipants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ThreadParticipants);

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
     * Test getThreadParticipant method
     *
     * @return void
     */
    public function testGetThreadParticipant()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getThreadOfUsers method
     *
     * @return void
     */
    public function testGetThreadOfUsers()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
