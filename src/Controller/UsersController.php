<?php

namespace GintonicCMS\Controller;

use GintonicCMS\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{

    /**
     * TODO: Write Comment
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'signin',
            'signup',
            'signout',
            'verify',
            'recover',
            'updateAvatar',
            'profile',
            'sendRecovery'
        ]);
    }

    /**
     * TODO: Write Comment
     */
    public function isAuthorized($user = null)
    {
        return true;
        parent::isAuthorized($user);
    }

    /**
     * TODO: blockquote
     */
    public function view()
    {
        if (!$this->request->session()->check('Auth.User.id')) {
            $this->Flash->set(__('Please Login to view this page.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-waning']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }
        $user = $this->Users->find('usersDetails', ['Users.id' => $this->request->session()->read('Auth.User.id')]);
        $this->set(compact('user'));
    }

    /**
     * TODO: blockquote
     */
    public function edit()
    {
        if (!$this->request->session()->check('Auth.User.id')) {
            $this->Flash->set(__('You are not a authorised to access this page.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect($this->request->referer());
        }

        $user = $this->Users->find('usersDetails', ['Users.id' => $this->request->session()->read('Auth.User.id')]);

        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->set(__('User has been updated.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->set(__('Error saving the user.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
        $this->set(compact('user'));
    }

    /**
     * TODO: blockquote
     */
    public function signup()
    {
        $this->render('GintonicCMS.signup', 'GintonicCMS.bare');
        $user = $this->Auth->user();
        if (!empty($user)) {
            $this->Flash->set(__('You are already signed in.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-warning']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }
        
        $user = $this->Users->newEntity($this->request->data);
        if ($this->request->is(['post', 'put'])) {
            $user->token = md5(uniqid(rand(), true));
            $user->token_creation = date("Y-m-d H:i:s");
            
            if ($this->Users->save($user)) {
                
                $user->sendSignup($this->request->data['email']);
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
        $this->set('user', $user);
    }

    /**
     * TODO: blockquote
     */
    public function signin()
    {
        $this->render('GintonicCMS.signin', 'GintonicCMS.bare');
        $user = $this->Auth->user();
        if (!empty($user)) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->loadModel('GintonicCMS.Files');
                $user['file'] = $this->Files->find()
                    ->where(['Files.id' => $user['file_id']])
                    ->select(['id', 'filename'])
                    ->first();
                if (!empty($user['file'])) {
                    $user['file'] = $user['file']->toArray();
                } else {
                    $user['file'] = ['id' => 0, 'filename' => 'default'];
                }
                $this->Auth->setUser($user);
                if (isset($this->request->data['remember'])) {
                    $this->Cookie->rememberMe($this->request->session()->read('Auth'));
                }
                if (empty($user['validated'])) {
                    $this->Flash->set(__('Login successful. Please validate your email address.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-warning']
                    ]);
                }
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->set(__('Your username or password is incorrect.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-warning']
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
        return $this->redirect($this->Auth->logout());
    }

    /**
     * TODO: blockquote
     */
    public function profile()
    {
        if (!$this->request->session()->check('Auth.User.id')) {
            $this->Flash->set(__('You are not signed in'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect($this->Auth->logout());
        }
    }

    public function verify($userId = null, $token = null)
    {
        $response = $this->Users->verifyUser($userId, $token);
        $redirect = $this->Auth->redirectUrl();

        if ($response['success'] && !isset($response['alreadyVarified'])) {
            $this->Auth->setUser($response['user']->toArray());
            $redirect = [
                'plugin' => 'GintonicCMS',
                'controller' => 'users',
                'action' => 'profile'
            ];
        }
        $this->Flash->set($response['message'], [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => $response['class']]
        ]);
        return $this->redirect($redirect);
    }

    /**
     * TODO: blockquote
     */
    public function changePassword()
    {
        if ($this->request->is(['post', 'put'])) {
            $userId = $this->request->session()->read('Auth.User.id');
            $response = $this->Users->changePassword($this->request->data, $userId);
            $this->Flash->set($response['message'], [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => $response['class']]
            ]);
            if ($response['success']) {
                return $this->redirect(['controller' => 'users', 'action' => 'profile']);
            }
        }
    }

    /**
     * TODO: blockquote
     */
    public function recover($userId = null, $token = null)
    {
        if ($userId && $token) {
            $response = $this->Users->verifyToken($userId, $token);

            if ($response['status'] == 'fail') {
                $this->Flash->set(__($arrResponse['message']), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-warning']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            }
        } else {
            $this->Flash->set(__('Forgot Password token is expired'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
        if ($this->request->is(['post', 'put'])) {
            $response = $this->Users->recoverPassword($this->request->data, $userId);

            if ($response['success']) {
                $this->Flash->set($response['message'], [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->set($response['message'], [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
        $this->set(compact('userId', 'token'));
        $this->render('GintonicCMS.recover', 'GintonicCMS.bare');
    }
    /*
     * TODO: Write comment
     */

    public function sendVerification()
    {
        if ($this->request->is(['post', 'put'])) {
            $response = $this->Users->resendVerification($this->request->data['email']);

            $this->Flash->set(__($response['message']), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => $response['class']]
            ]);
            if ($response['success']) {
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }

    /**
     * TODO: blockquote
     */
    public function sendRecovery()
    {
        if ($this->Auth->user()) {
            $this->Flash->set(__('You are already signed in.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-warning']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is(['post', 'put'])) {
            $response = $this->Users->sendPasswordRecovery($this->request->data['email']);
            $this->Flash->set(__($response['message']), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => $response['class']]
            ]);
            if ($response['success']) {
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        $this->render('GintonicCMS.send_recovery', 'GintonicCMS.bare');
    }
}
