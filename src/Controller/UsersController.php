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
            'sendVerification',
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
        $user->accessible('password', true);
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
                if (empty($user['verified'])) {
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
        if (empty($userId) || empty($token)) {
            $this->Flash->set(__('The authorization link provided is erroneous, please contact an administrator.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }

        $user = $this->Users->find('usersDetails', ['Users.id' => $userId]);
        debug($user);
        exit;
        if (!empty($user->verified)) {
            $this->Flash->set(__('Your email address is already validated.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-success']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->Users->verifyUser($user, $token)) {
            $this->Flash->set(__('Email address has been successfuly validated.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-success']
            ]);
            return $this->redirect([
                    'plugin' => 'GintonicCMS',
                    'controller' => 'users',
                    'action' => 'profile'
            ]);
        }
        $this->Flash->set(__('Error occure while validating you email. Please try again.'), [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => 'alert-danger']
        ]);
        return $this->redirect($this->Auth->redirectUrl());
    }

    /**
     * TODO: blockquote
     */
    public function changePassword()
    {
        if ($this->request->is(['post', 'put'])) {
            $userId = $this->request->session()->read('Auth.User.id');

            if ($this->request->data['new_password'] != $this->request->data['confirm_password']) {
                $this->Flash->set(__('Confirm Password entered does not match.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else if ($this->request->data['new_password'] == "") {
                $this->Flash->set(__('New Password Must Not Blank.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else {
                if ($this->Users->changePassword($this->request->data, $userId)) {
                    $this->Flash->set(__('Password has been updated Successfully.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-success']
                    ]);
                    return $this->redirect(['controller' => 'users', 'action' => 'profile']);
                }
            }
        }
    }

    /**
     * TODO: blockquote
     */
    public function recover($userId = null, $token = null)
    {
        if ($userId && $token) {
            if (!$this->Users->verifyToken($userId, $token)) {
                $this->Flash->set(__('Forgot Password token is expired.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            }
        } else {
            $this->Flash->set(__('Forgot Password token is expired.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
        if ($this->request->is(['post', 'put'])) {
            if ($this->request->data['new_password'] != $this->request->data['confirm_password']) {
                $this->Flash->set(__('New Password and Confirm Password must be same.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else {
                if ($this->Users->recoverPassword($this->request->data, $userId)) {
                    $this->Flash->set(__('Your password has been updated successfully.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-success']
                    ]);
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->set(__('Error occure while reseting your password, Please try again.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-danger']
                    ]);
                }
            }
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
            $user = $this->Users->find('usersDetails', ['email' => $this->request->data['email']]);

            if (empty($user)) {
                $this->Flash->set(__('No matching email found. Please try with correct email address.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else if (!empty($user['validated'])) {
                $this->Flash->set(__('Your email address is already validated.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-info']
                ]);
            } else {
                if ($this->Users->sendVerification($user, $this->request->data['email'])) {
                    $this->Flash->set(__('The email was resent. Please check your inbox.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-success']
                    ]);
                    return $this->redirect($this->Auth->redirectUrl());
                }
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
            $user = $this->Users->find('usersDetails', ['email' => $this->request->data['email']]);

            if (empty($user)) {
                $this->Flash->set(__('No matching email address found.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else {
                if ($this->Users->sendPasswordRecovery($user)) {
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
