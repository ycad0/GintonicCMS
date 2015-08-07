<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\CustomersTable;

/**
 * GintonicCMS\Model\Table\CustomersTable Test Case
 */
class CustomersTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.gintonic_c_m_s.customers',
        'plugin.gintonic_c_m_s.stripe_customers',
        'plugin.gintonic_c_m_s.users',
        'plugin.gintonic_c_m_s.message_read_statuses',
        'plugin.gintonic_c_m_s.messages',
        'plugin.gintonic_c_m_s.threads',
        'plugin.gintonic_c_m_s.threads_users',
        'plugin.gintonic_c_m_s.aros',
        'plugin.gintonic_c_m_s.acos',
        'plugin.gintonic_c_m_s.permissions',
        'plugin.gintonic_c_m_s.charges',
        'plugin.gintonic_c_m_s.subscriptions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Customers') ? [] : ['className' => 'GintonicCMS\Model\Table\CustomersTable'];
        $this->Customers = TableRegistry::get('Customers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Customers);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
