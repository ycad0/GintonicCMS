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
        'plugin.gintonic_c_m_s.threads',
        'plugin.gintonic_c_m_s.messages',
        'plugin.gintonic_c_m_s.users',
        'plugin.gintonic_c_m_s.threads_users',
        'plugin.gintonic_c_m_s.message_read_statuses'
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
        $this->assertInstanceOf(
            'Cake\ORM\Association\BelongsToMany',
            $this->Threads->Users
        );
        $this->assertInstanceOf(
            'Cake\ORM\Association\HasMany',
            $this->Threads->Messages
        );
    }

    /**
     * Test findWithUsers method
     *
     * @return void
     */
    public function testFindWithUsers()
    {
        $users = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];

        $query = $this->Threads->find('withUsers',$users)->select(['id']);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->hydrate(false)->toArray();
        
        $expected = [
            ['id' => 1],
            ['id' => 2],
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Test findDetails method
     *
     * @return void
     */
    public function testFindDetails()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findParticipant method
     *
     * @return void
     */
    public function testFindParticipant()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findWithUserCount method
     *
     * @return void
     */
    public function testFindWithUserCount()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findUnread method
     *
     * @return void
     */
    public function testFindUnread()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findDeleted method
     *
     * @return void
     */
    public function testFindDeleted()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
