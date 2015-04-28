<?php
namespace GintonicCMS\Controller;

use Cake\Event\Event;
use GintonicCMS\Controller\AppController;

class UsersController extends AppController
{

    /**
     * TODO: blockquote
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'signin',
            'signup',
            'signout',
            'confirmation',
            'forgot_password',
            'reset_password',
            'update_avatar',
            'profile'
        ]);
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
        $user = $this->Users->safeRead([
            'Users.id' => $this->request->session()->read('Auth.User.id')
        ]);
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
        $user = $this->Users->safeRead(
            ['Users.id' => $this->request->session()->read('Auth.User.id')],
            true
        );
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
    public function updateAvatar($userId = null, $fileId = null)
    {
        if (!empty($this->request->data['id'])) {
            $userId = $this->request->data['id'];
        }
        if (!empty($this->request->data['file_id'])) {
            $fileId = $this->request->data['file_id'];
        }
        $user = $this->Users->safeRead(['Users.id' => $userId]);
        if (!empty($user->file_id)) {
            $oldFile = $user->file_id;
        }
        $user->file_id = $this->request->data['file_id'];
        if ($this->Users->save($user)) {
            $this->loadModel('GintonicCMS.Files');
            if (!empty($oldFile)) {
                $file = $this->Files->get($oldFile);
                $this->Files->deleteFile($file->filename, $file->id);
            }
            $file = $this->Files->get($fileId);
            echo json_encode(array(
                'message' => __('Profile photo has been change successfully.'),
                'success' => true,
                'file' => '/' . $this->Files->getUrl($file->filename),
            ));
        } else {
            echo json_encode(array(
                'message' => __('Unable to change profile photo, Try again.'),
                'success' => false
            ));
        }
        exit;
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
            if ($this->Users->save($user)) {
                $this->Users->signupMail($this->request->data['email']);
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

    /**
     * TODO: blockquote
     */
    public function confirmation($userId = null, $token = null)
    {
        if ($userId || $token) {
            $user = $this->Users->safeRead(['Users.id' => $userId]);
            if (!empty($user['validated'])) {
                $this->Flash->set(__('Your email address is already validated, please use email and password to login'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-info']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            } elseif (!empty($user)) {
                $user = $this->Users->confirmation($userId, $token);
                $this->Auth->setUser($user->toArray());
                $this->Flash->set(__('Email address successfuly validated'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-sucess']
                ]);
                return $this->redirect([
                    'plugin' => 'GintonicCMS',
                    'controller' => 'users',
                    'action' => 'profile'
                ]);
            } else {
                $this->Flash->set(__('The authorization link provided is erroneous, please contact an administrator'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        $this->Flash->set(__('Please check your e-mail for validation link'), [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => 'alert-warning']
        ]);
        return $this->redirect($this->Auth->redirectUrl());
    }

    /**
     * TODO: blockquote
     */
    public function changePassword()
    {
        if (!empty($this->request->data)) {
            $userDetail = $this->Users->get($this->request->session()->read('Auth.User.id'));
            if ($this->request->data['new_password'] != $this->request->data['confirm_password']) {
                $this->Flash->set(__('Confirm Password entered does not match.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } elseif ($this->request->data['new_password'] == "") {
                $this->Flash->set(__('New Password Must Not Blank'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else {
                $this->request->data['id'] = $this->request->session()->read('Auth.User.id');
                $this->request->data['password'] = $this->request->data['new_password'];
                $users = $this->Users->patchEntity($userDetail, $this->request->data);
                if ($this->Users->save($users)) {
                    $this->Flash->set(__('Password has been updated Successfully.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-success']
                    ]);
                    return $this->redirect(['controller' => 'users', 'action' => 'profile']);
                } else {
                    $this->Flash->set(__('Unable to Change Password, Please try again.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-danger']
                    ]);
                }
            }
        }
    }

    /**
     * TODO: blockquote
     */
    public function resetPassword($userId = null, $token = null)
    {
        if ($userId && $token) {
            $arrResponse = $this->Users->checkForgotPassword($userId, $token);
            if ($arrResponse['status'] == 'fail') {
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
        $this->set(compact('userId', 'token'));
        if ($this->request->is(['post', 'put'])) {
            if ($this->request->data['new_password'] != $this->request->data['confirm_password']) {
                $this->Flash->set(__('New Password and Confirm Password must be same'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else {
                $this->request->data['id'] = $userId;
                $this->request->data['password'] = $this->request->data['new_password'];
                $this->request->data['token'] = md5(uniqid(rand(), true));
                $this->request->data['token_creation'] = date("Y-m-d H:i:s");
                $users = $this->Users->newEntity($this->request->data);
                $this->Users->save($users);
                $this->Flash->set(__('Your password has been updated successfully'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }

    /**
     * TODO: blockquote
     */
    public function resendVerification()
    {
        if ($this->request->is(['post', 'put'])) {
            $arrResponse = $this->Users->resendVerification($this->request->data['email']);
            if (!empty($arrResponse)) {
                if ($arrResponse['status'] == 'fail') {
                    $this->Flash->set(__($arrResponse['message']), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-warning']
                    ]);
                } else {
                    $this->Flash->set(__($arrResponse['message']), [
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
    public function forgotPassword()
    {
        //Check For Already Logged In
        if ($this->Auth->user()) {
            $this->Flash->set(__('You are already signed in.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-warning']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is(['post', 'put'])) {
            $arrResponse = $this->Users->forgotPasswordEmail($this->request->data['email']);
            if (!empty($arrResponse)) {
                if ($arrResponse['status'] == 'fail') {
                    $this->Flash->set(__($arrResponse['message']), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-warning']
                    ]);
                } else {
                    $this->Flash->set(__($arrResponse['message']), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-success']
                    ]);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
    }
}
