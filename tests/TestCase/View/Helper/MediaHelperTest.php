<?php
namespace GintonicCMS\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use GintonicCMS\View\Helper\MediaHelper;

/**
 * GintonicCMS\View\Helper\MediaHelper Test Case
 */
class MediaHelperTest extends TestCase
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
        $this->File = new MediaHelper($view);
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
     * Test getYouTubeUrl method
     *
     * @return void
     */
    public function testGetYouTubeUrl()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
