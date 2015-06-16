<?php
/**
 * GintonicCMS : Full Stack Content Management System (http://gintoniccms.com)
 * Copyright (c) Philippe Lafrance (http://phillafrance.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Philippe Lafrance (http://phillafrance.com)
 * @link          http://gintoniccms.com GintonicCMS Project
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace GintonicCMS\Controller;

use Cake\Event\Event;
use GintonicCMS\Controller\AppController;

/**
* Users Controller
*
* Meant to handle the mechanics of logging users in, password management and
* authentication. This base class is intended to stay as lean as possible while
* being easily reusable from any application.
*/
class UsersController extends AppController
{
    /**
     * Defines the methods that should be allowed for non logged-in users.
     *
     * @param Event $event An Event instance
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'signin',
            'signup',
            'verify',
            'recover',
        ]);

        $this->Cookie->config('path', '/');
        $this->Cookie->config([
            'httpOnly' => true
        ]);
    }

    /**
     * Authorization method. We can grant all permissions to everything 
     * on the website by adding a user to the group named 'all'.
     * 
     * @param array|null $user The user to check the authorization of.
     * @return bool True if $user is authorized, otherwise false
     */
    public function isAuthorized($user = null)
    {
        if (!empty($user)) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    /**
     * View users information (name and password). If no user is specified,
     * show own profile.
     *
     * @param int $id the id of the user we want to consult
     */
    public function view($id = null)
    {
        if (empty($id) && $this->request->session()->read('Auth.User.id')) {
            $id = $this->request->session()->read('Auth.User.id');
        }
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    /**
     * Allows users to edit their own information
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($id);
        $user->accessible('password', true);
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->set(__('User has been updated'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
            } else {
                $this->Flash->set(__('Error saving the user'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            }
        }
        $this->set(compact('user'));
    }

    /**
     * TODO: blockquote
     */
    public function signup()
    {
        // TODO: move this condition into isAuthorized()
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $this->render('GintonicCMS.signup', 'GintonicCMS.bare');
        $user = $this->Users->newEntity()->accessible('password', true);
        if ($this->request->is(['post', 'put'])) {
            $user->updateToken();
            $user = $this->Users->patchEntity($user, $this->request->data);

            if ($this->Users->save($user)) {
                $user->sendSignup();
                $this->Flash->set(__('Please check your e-mail to validate your account'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-warning']
                ]);
                $this->Auth->setUser($user->toArray());
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->set(__('Error creating your account, please contact an administrator'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
        $this->set(compact('user'));
    }

    /**
     * TODO: blockquote
     */
    public function signin()
    {
        // TODO: move this condition into isAuthorized()
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $this->render('GintonicCMS.signin', 'GintonicCMS.bare');
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                if (isset($this->request->data['remember'])) {
                    $this->Cookie->write('User', $user);
                }
                if ($user->verified) {
                    $this->Flash->set(__('Login successful. Please validate your email address.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-warning']
                    ]);
                }
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->set(__('Your username or password is incorrect.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
    }

    /**
     * TODO: blockquote
     */
    public function signout()
    {
        $this->Cookie->forgetMe();
        $this->request->session()->destroy();
        $this->Flash->set(__('You are now signed out.'), [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => 'alert-info']
        ]);
        $this->Cookie->delete('User');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * TODO: blockquote
     */
    public function verify($userId, $token)
    {
        $user = $this->Users->get($userId);

        if ($user->verified || $user->verify($token)) {
            $this->Users->save($user);
            $this->Flash->set(__('Email address has been successfuly validated.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-success']
            ]);
        } else {
            $this->Flash->set(__('Error occure while validating you email. Please try again.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
        return $this->redirect($this->Auth->redirectUrl());
    }

    /**
     * TODO: blockquote
     */
    public function changePassword()
    {
        if ($this->request->is(['post', 'put'])) {
            $userId = $this->request->session()->read('Auth.User.id');

            if ($this->Users->changePassword($this->request->data, $userId)) {
                $this->Flash->set(__('Password has been updated Successfully.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->set(__('Error occure while updating you password. Please try again.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            }
        }
    }

    /**
     * TODO: blockquote
     * This is where users end up from their
     */
    public function recover($userId, $token)
    {
        $user = $this->Users->get($userId);
        if (!$user->verify($token)) {
            $this->Flash->set(__('Recovery token is expired'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is(['post', 'put'])) {
            $this->Users->save($user);
            if ($this->Users->changePassword($this->request->data, $userId)) {
                // TODO: sign users in
                $this->Flash->set(__('Password has been updated Successfully.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->set(__('Error while reseting your password, Please try again.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            }
        }
        $this->set(compact('userId', 'token'));
        $this->render('GintonicCMS.recover', 'GintonicCMS.bare');
    }

    /**
     * TODO: Write comment
     */
    public function sendVerification()
    {
        $userId = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($userId);

        if ($user->sendVerification()) {
            $this->Flash->set(__('The email was resent. Please check your inbox.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-success']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }
    }

    /**
     * TODO: blockquote
     */
    public function sendRecovery()
    {
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->findByEmail($this->request->data['email'])->first();

            if (empty($user)) {
                $this->Flash->set(__('No matching email address found.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else {
                // TODO: write a test that vaidates that the token is updated
                // careful: this is a guarded field
                $user->updateToken();
                if ($this->Users->save($user)) {
                    $user->sendRecovery();
                    $this->Flash->set(__('An email was sent with password recovery instructions.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-success']
                    ]);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
        $this->render('GintonicCMS.send_recovery', 'GintonicCMS.bare');
    }
}
