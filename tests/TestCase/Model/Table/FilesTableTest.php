<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\FilesTable;

/**
 * GintonicCMS\Model\Table\FilesTable Test Case
 */
class FilesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Files' => 'plugin.gintonic_c_m_s.files',
        'Users' => 'plugin.gintonic_c_m_s.users',
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
        $config = TableRegistry::exists('Files') ? [] : ['className' => 'GintonicCMS\Model\Table\FilesTable'];
        $this->Files = TableRegistry::get('Files', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Files);

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
     * Test moveUploaded method
     *
     * @return void
     */
    public function testMoveUploaded()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test createFileName method
     *
     * @return void
     */
    public function testCreateFileName()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getPath method
     *
     * @return void
     */
    public function testGetPath()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getUrl method
     *
     * @return void
     */
    public function testGetUrl()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test deleteFile method
     *
     * @return void
     */
    public function testDeleteFile()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
