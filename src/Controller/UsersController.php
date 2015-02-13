<?php
namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Event\Event;

class UsersController extends AppController {

    public $uses = array('GintonicCMS.Users');
    
    public $helpers = ['Form', 'Html', 'Time'];
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Auth');
        $this->loadComponent('GintonicCMS.GtwCookie');
//        $this->Auth->allow('change_password','signup', 'signin', 'signout', 'confirmation', 'forgot_password', 'reset_password', 'resend_verification', 'public_profile');
        $this->Auth->allow();
        if ($this->request->Session()->read('Auth.Users')) {
            $this->Auth->allow('edit');
        }
        if (is_null(\Cake\Core\Configure::read('Gtw.admin_mail'))) {
            echo 'Users plugin configuration error';
            exit;
        }
    }

    public function index() {
        debug('index of users');
        exit;
        $this->layout = 'GintonicCMSs.users';
        $this->Users->recursive = 0;
        $arrConditions = array();
        if ($this->Session->read('Auth.Users.role') != 'admin') {
            //$arrConditions = array('company_id'=>$this->Session->read('Auth.Users.company_id'));
        }
        $this->paginate = array(
            'Users' => array(
                'order' => array('id' => 'desc'),
            //'conditions' => $arrConditions
            )
        );
        $this->set('users', $this->paginate('Users'));
    }

    public function delete($id = null) {
        $this->Users->id = $id;
        if (!$this->Users->exists()) {
            $this->Flash->warning(__('Invalid user'));
        }
        if ($this->Users->delete()) {
            $this->Flash->success(__('Users deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->warning(__('Users was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

    public function edit($userId = 0) {
        if (!$userId) {
            $this->Flash->warning(__('Invalid user'));
            return $this->redirect(array('action' => 'signin'));
        }
        $user = $this->Users->get($id);
        if ($this->request->is(['post','put'])) {
            $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->warning(__('The user could not be saved. Please, try again.'));
        } else {
//            $this->set('article', $article);
//            $this->request->data = $this->Users->safeRead(null, $this->Users->id);
//            if (!empty($this->request->data['File']['filename'])) {
//                $this->set('avatar', $this->Users->File->getUrl($this->request->data['File']['filename']));
//            }
        }
        $this->set('users', $user);
    }

    public function signin() {
        $this->layout = 'GintonicCMS.Users';
        if ($this->request->is('post')) {
            // login
            $user = $this->Auth->identify();
            debug($user);
            debug($this->request->data['data']['Users']['password']);
            
            debug($this->request->data);
            exit;
            if ($user) {
                $this->Auth->setUser($user);
                if (isset($this->request->data['Users']['remember'])) {
                    $this->GtwCookie->rememberMe(CakeSession::read("Auth"));
                }
                // Users needs to be validated
                if (!$this->Users->isValidated($this->request->data['Users']['email'])) {
                    $this->Flash->warning(__('Please validate your email address.'));
                }
                if ($this->Session->read('Auth.Users.role') == 'admin') {
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    if(!empty(Configure::read('GintonicCMS.userLoginRedirect'))){
                        return $this->redirect(Configure::read('GintonicCMS.userLoginRedirect'));
                    }
                    return $this->redirect(array('action'=>'profile'));
                }
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->warning(__('Username or password is incorrect'));
            }
        }
    }

    public function signout() {
        $this->GtwCookie->forgetMe();
        return $this->redirect($this->Auth->logout());
    }

    public function signup() {
        $this->layout = 'GintonicCMS.users';
        $user = $this->Users->newEntity($this->request->data);
        if ($this->request->is('post')) {
            if ($this->Users->save($user)) {
                //$this->Users->signupMail($this->request->data['Users']['email']);
                $this->Flash->success(__('Please check your e-mail to validate your account'));
                return $this->redirect(['action' => 'signin']);
            }
            $this->Flash->warning(__('Error creating your account, please contact an administrator'));
        }
        $this->set('user', $user);

//        if ($this->request->is('post')) {
//            $user = $this->Users->newEntity($this->request->data);
////            $this->Auth->password();
////            debug((new DefaultPasswordHasher)->hash('123456'));
//            if ($this->Users->save($user)) {
//                //$this->Auth->setUser($user->toArray());
//                //$this->Users->signupMail($this->request->data['Users']['email']);
//                $this->Flash->success(__('Please check your e-mail to validate your account'));
//                //return $this->redirect($this->Auth->redirectUrl());
//            } else {
//                debug($user->errors());
//                exit;
//                $this->Flash->warning(__('Error creating your account, please contact an administrator'));
//            }
//        }
    }

    public function confirmation($userId = null, $token = null) {
        $this->layout = 'GintonicCMS.users';

        if ($userId || $token) {
            $user = $this->Users->confirmation($userId, $token);
            if (!empty($user['Users']['validated'])) {
                $this->Session->setFlash('Your email address is already validated, please use email and password to login', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            } elseif (isset($user) && $this->Auth->login($user['Users'])) {
                $this->Session->setFlash('Email address successfuly validated', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash('The authorization link provided is erroneous, please contact an administrator', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            }
        }

        $this->Session->setFlash('Please check your e-mail for validation link', 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-info'
        ));
        return $this->redirect($this->Auth->redirectUrl());
    }

    public function view($id = null) {
        $this->Users->id = $id;

        if (!$this->Users->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->Users->safeRead(null, $id));
        if (CakePlugin::loaded('GtwFiles')) {
            $this->render('/Users/view_avatar');
        }
    }

    public function update_avatar($userId = 0, $fileId = 0) {
        if (!empty($this->request->data['id'])) {
            $userId = $this->request->data['id'];
        }
        if (!empty($this->request->data['file_id'])) {
            $fileId = $this->request->data['file_id'];
        }
        $user = $this->Users->safeRead(null, $userId);
        $oldFile = $user['Users']['file_id'];
        $user['Users']['file_id'] = $fileId;

        if ($this->Users->save($user)) {
            $this->Users->File->deleteFile($oldFile);
            $this->Users->File->id = $fileId;
            return new CakeResponse(array(
                'body' => json_encode(array(
                    'message' => __('Profile photo has been change successfully.'),
                    'success' => True,
                    'file' => '/' . $this->Users->File->getUrl($this->Users->File->field('filename')),
                )),
                'status' => 200
            ));
        } else {
            return new CakeResponse(array(
                'body' => json_encode(array(
                    'message' => __('Unable to change profile photo, Try again.'),
                    'success' => false
                )),
                'status' => 200
            ));
        }
    }

    public function forgot_password() {
        //Check For Already Logged In
        if ($this->Auth->login()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->layout = 'GintonicCMSs.users';
        if ($this->request->is('post')) {
            $arrResponse = $this->Users->ForgotPasswordEmail($this->request->data['Users']['email']);
            if (!empty($arrResponse)) {
                if ($arrResponse['status'] == 'fail') {
                    $this->Session->setFlash($arrResponse['message'], 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                    ));
                } else {
                    $this->Session->setFlash($arrResponse['message'], 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
    }

    public function reset_password($userId = null, $token = null) {
        $this->layout = 'GintonicCMSs.users';
        if ($userId && $token) {
            $arrResponse = $this->Users->checkForgotPassword($userId, $token);
            if ($arrResponse['status'] == 'fail') {
                $this->Session->setFlash($arrResponse['message'], 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->loginAction);
            }
        } else {
            $this->Session->setFlash('Invalid Token', 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
            return $this->redirect($this->Auth->loginAction);
        }
        $this->set(compact('userId', 'token'));
        if ($this->request->is('post')) {
            if ($this->request->data['Users']['new_password'] != $this->request->data['Users']['new_password']) {
                $this->Session->setFlash('New Password and Confirm Password must be same', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            } else {
                $this->request->data['Users']['id'] = $userId;
                $this->request->data['Users']['password'] = $this->request->data['Users']['new_password'];
                $this->request->data['Users']['token'] = md5(uniqid(rand(), true));
                $this->request->data['Users']['token_creation'] = date("Y-m-d H:i:s");
                $this->Users->save($this->request->data);

                $this->Session->setFlash('Your password has been updated successfully', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect($this->Auth->loginAction);
            }
        }
    }

    public function add() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data["Users"]["validated"] = 1;
            if ($this->Users->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been created successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add user. Please, try again.'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
        $this->set('users', $this->Users->find('list'));
    }

    public function public_profile($userId) {
        if (!empty($userId)) {
            $files = $this->Users->File->find('all',array('conditions'=>array('File.user_id'=>$userId),'recursive'=>-1));
            $userDetails = $this->Users->safeRead(null, $userId);
            if (!empty($userDetails['File']['filename'])) {
                $this->set('avatar', $this->Users->File->getUrl($userDetails['File']['filename']));
            }
            $this->set(compact('userDetails'));
            $this->set(compact('files'));
        }
    }

    function profile() {
        
    }

    public function change_password() {
        if (!empty($this->request->data)) {
            $password = $this->Users->find('first', array(
                'fields' => array('password'),
                'conditions' => array(
                    'id' => $this->Session->read('Auth.Users.id')
                ),
                'recursive' => "-1")
            );

            if (AuthComponent::password($this->request->data ['Users']['current_password']) != $password ['Users'] ['password']) {
                $this->Session->setFlash(__('Old Password does not match.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            } elseif ($this->request->data ['Users'] ['new_password'] != $this->request->data ['Users'] ['confirm_password']) {
                $this->Session->setFlash(__('Confirm Password entered does not match.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            } elseif ($this->request->data ['Users'] ['new_password'] == "") {
                $this->Session->setFlash(__('New Password Must Not Blank'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            } else {
                $this->request->data['Users']['id'] = $this->Session->read('Auth.Users.id');
                $this->request->data['Users']['password'] = $this->request->data['Users']['new_password'];
                $this->request->data['Users']['confirm_password'] = AuthComponent::password($this->request->data ['Users']['confirm_password']);
                if ($this->Users->save($this->request->data)) {
                    $this->Session->setFlash(__('Password has been updated Successfully.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('Unable to Change Password, Please try again.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                    ));
                }
            }
        }
    }

    /**
     * Checks if an email is already verified and if not renews the expiration time
     *
     * @return void
     */
    public function resend_verification() {
        if ($this->request->is('post')) {
            $arrResponse = $this->Users->ResendVerification($this->request->data['Users']['email']);
            if (!empty($arrResponse)) {
                if ($arrResponse['status'] == 'fail') {
                    $this->Session->setFlash($arrResponse['message'], 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                    ));
                } else {
                    $this->Session->setFlash($arrResponse['message'], 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
    }

}
