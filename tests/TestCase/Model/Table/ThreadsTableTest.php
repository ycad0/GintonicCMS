<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\ThreadsTable;

/**
 * GintonicCMS\Model\Table\ThreadsTable Test Case
 */
class ThreadsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Threads' => 'plugin.gintonic_c_m_s.threads',
        'Users' => 'plugin.gintonic_c_m_s.users',
        'Files' => 'plugin.gintonic_c_m_s.files',
        'Albums' => 'plugin.gintonic_c_m_s.albums',
        'ThreadParticipants' => 'plugin.gintonic_c_m_s.thread_participants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Threads') ? [] : ['className' => 'GintonicCMS\Model\Table\ThreadsTable'];
        $this->Threads = TableRegistry::get('Threads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Threads);

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
     * Test getThread method
     *
     * @return void
     */
    public function testGetThread()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getGroups method
     *
     * @return void
     */
    public function testGetGroups()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getGroupAdmin method
     *
     * @return void
     */
    public function testGetGroupAdmin()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
