<?php
namespace GintonicCMS\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use GintonicCMS\Model\Table\UsersTable;

/**
 * GintonicCMS\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    //public $fixtures = [
    //    'Users' => 'plugin.gintonic_c_m_s.users',
    //    'Files' => 'plugin.gintonic_c_m_s.files',
    //    'Albums' => 'plugin.gintonic_c_m_s.albums'
    //];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Users') ? [] : ['className' => 'GintonicCMS\Model\Table\UsersTable'];
        $this->Users = TableRegistry::get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

        parent::tearDown();
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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test isValidated method
     *
     * @return void
     */
    public function testIsValidated()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test signupMail method
     *
     * @return void
     */
    public function testSignupMail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendSignupMail method
     *
     * @return void
     */
    public function testSendSignupMail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test forgotPasswordEmail method
     *
     * @return void
     */
    public function testForgotPasswordEmail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendForgotPasswordEmail method
     *
     * @return void
     */
    public function testSendForgotPasswordEmail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findCustomPassword method
     *
     * @return void
     */
    public function testFindCustomPassword()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test checkForgotPassword method
     *
     * @return void
     */
    public function testCheckForgotPassword()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test resendVerification method
     *
     * @return void
     */
    public function testResendVerification()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test resendVerificationEmail method
     *
     * @return void
     */
    public function testResendVerificationEmail()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
