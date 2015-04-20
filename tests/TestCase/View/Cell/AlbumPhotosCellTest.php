<?php
namespace GintonicCMS\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;
use GintonicCMS\View\Cell\AlbumPhotosCell;

/**
 * GintonicCMS\View\Cell\AlbumPhotosCell Test Case
 */
class AlbumPhotosCellTest extends TestCase
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
        $this->AlbumPhotos = new AlbumPhotosCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AlbumPhotos);

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
