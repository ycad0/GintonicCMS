<?php
namespace GintonicCMS\Test\TestCase\View\Helper;

use GintonicCMS\View\Helper\PaginatorHelper;
use Cake\TestSuite\TestCase;
use Cake\View\Helper;
use Cake\View\View;

/**
 * BootstrapPaginatorHelper Test Case
 *
 */
class PaginatorHelperTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $View = new View();
        $this->Paginator = new PaginatorHelper($View);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Paginator);

        parent::tearDown();
    }

    /**
     * testPaginationEmpty
     *
     * @return void
     */
    public function testPaginationEmpty()
    {
        $this->Paginator->request->params['paging']['Post'] = [
            'page' => 1,
            'current' => 0,
            'count' => 0,
            'prevPage' => false,
            'nextPage' => false,
            'pageCount' => 1,
            'order' => null,
            'limit' => 20,
            'options' => [
                'page' => 1,
                'conditions' => []
            ],
            'paramType' => 'named'
        ];
        $numbers = $this->Paginator->pagination(['model' => 'Post']);
        $this->assertSame('', $numbers);
    }

}
