<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\SubscriptionsTable;

/**
 * GintonicCMS\Model\Table\SubscriptionsTable Test Case
 */
class SubscriptionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.gintonic_c_m_s.subscriptions',
        'plugin.gintonic_c_m_s.stripe_subscriptions',
        'plugin.gintonic_c_m_s.plans',
        'plugin.gintonic_c_m_s.aros',
        'plugin.gintonic_c_m_s.acos',
        'plugin.gintonic_c_m_s.permissions',
        'plugin.gintonic_c_m_s.customers',
        'plugin.gintonic_c_m_s.stripe_customers',
        'plugin.gintonic_c_m_s.users',
        'plugin.gintonic_c_m_s.message_read_statuses',
        'plugin.gintonic_c_m_s.messages',
        'plugin.gintonic_c_m_s.threads',
        'plugin.gintonic_c_m_s.threads_users',
        'plugin.gintonic_c_m_s.charges'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Subscriptions') ? [] : ['className' => 'GintonicCMS\Model\Table\SubscriptionsTable'];
        $this->Subscriptions = TableRegistry::get('Subscriptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Subscriptions);

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
