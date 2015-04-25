<?php
namespace GintonicCMS\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;
use GintonicCMS\View\Cell\AlbumsCell;

/**
 * GintonicCMS\View\Cell\AlbumsCell Test Case
 */
class AlbumsCellTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = $this->getMock('Cake\Network\Request');
        $this->response = $this->getMock('Cake\Network\Response');
        $this->Albums = new AlbumsCell($this->request, $this->response);
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
     * Test display method
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
