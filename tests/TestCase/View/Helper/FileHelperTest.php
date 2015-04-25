<?php
namespace GintonicCMS\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use GintonicCMS\View\Helper\FileHelper;

/**
 * GintonicCMS\View\Helper\FileHelper Test Case
 */
class FileHelperTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->File = new FileHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->File);

        parent::tearDown();
    }

    /**
     * Test getFileUrl method
     *
     * @return void
     */
    public function testGetFileUrl()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getYouTubeUrl method
     *
     * @return void
     */
    public function testGetYouTubeUrl()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
