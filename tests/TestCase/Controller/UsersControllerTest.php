<?php
namespace GintonicCMS\Test\TestCase\Controller;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\IntegrationTestCase;
use GintonicCMS\Controller\UsersController;

/**
 * GintonicCMS\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.gintonic_c_m_s.users',
        'plugin.gintonic_c_m_s.acos',
        'plugin.gintonic_c_m_s.aros',
        'plugin.gintonic_c_m_s.aros_acos'
    ];

    /**
     * Test beforeFilter method
     *
     * @return void
     */
    public function testBeforeFilter()
    {
        $this->get('/users/signin');
        $this->assertResponseOk();

        $this->get('/users/signup');
        $this->assertResponseOk();

        $this->get('/users/verify/1/jhfkjd456d4sgdsg');
        $this->assertSession('alert-success', 'Flash.flash.params.class');

        $this->get('/users/recover/1/jhfkjd456d4sgdsg');
        $this->assertResponseOk();

    }

    /**
     * Test isAuthorized method
     *
     * @return void
     */
    public function testIsAuthorized()
    {
        $this->get('/users/view');
        $this->assertResponseCode(302);

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1
                ]

            ]
        ]);
        $this->get('/users/view');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/users/view');
        $this->assertResponseCode(302);

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1
                ]

            ]
        ]);
        $this->get('/users/view');
        $this->assertResponseOk();
        $this->assertResponseNotEmpty();
        $this->assertResponseContains('Philippe');
        $this->assertResponseContains('Lafrance');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1
                ]

            ]
        ]);
        $this->get('/users/edit');
        $this->assertResponseOk();

        $this->post('/users/edit', [
            'email' => 'newmail@blackhole.io',
            'pwd' => '123456',
            'first' => 'Phil',
            'last' => 'Laf'
        ]);
        $this->assertResponseCode(302);

        $this->post('/users/edit', [
            'email' => 'newmail@blackhole.io',
            'pwd' => 'dummy',
            'first' => 'Phil',
            'last' => 'Laf'
        ]);
        $this->assertResponseCode(302);
    }

    /**
     * Test signup method
     *
     * @return void
     */
    public function testSignup()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test signin method
     *
     * @return void
     */
    public function testSignin()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test signout method
     *
     * @return void
     */
    public function testSignout()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test verify method
     *
     * @return void
     */
    public function testVerify()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test changePassword method
     *
     * @return void
     */
    public function testChangePassword()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test recover method
     *
     * @return void
     */
    public function testRecover()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendVerification method
     *
     * @return void
     */
    public function testSendVerification()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test sendRecovery method
     *
     * @return void
     */
    public function testSendRecovery()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
