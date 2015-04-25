<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\AlbumsTable;

/**
 * GintonicCMS\Model\Table\AlbumsTable Test Case
 */
class AlbumsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    //public $fixtures = [
    //    'Albums' => 'plugin.gintonic_c_m_s.albums',
    //    'Files' => 'plugin.gintonic_c_m_s.files',
    //    'Users' => 'plugin.gintonic_c_m_s.users'
    //];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Albums') ? [] : ['className' => 'GintonicCMS\Model\Table\AlbumsTable'];
        $this->Albums = TableRegistry::get('Albums', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Albums);

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
