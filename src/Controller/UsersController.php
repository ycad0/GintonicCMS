<?php
namespace GintonicCMS\Controller;

use GintonicCMS\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class UsersController extends AppController{
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Auth');
        TableRegistry::config('Users', ['table' => 'Users']);
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->__checklogin();
        $this->Auth->allow(['signin', 'signup','signout','confirmation', 'forgot_password','reset_password']);
    }
    
    public function index()
    {
        if($this->request->session()->read('Auth.User.role') != 'admin'){
            $this->Flash->warning(__('You don\'t have permission to add user'));
            $this->redirect(array('controller'=>'users','action'=>'profile'));
        }
        $arrConditions = ['Users.role'=>'user'];
        //$query = $this->Users->find('all')->where($arrConditions)->contain(['Files']);
        $this->paginate = array(
            'conditions' => $arrConditions,
//            'contain' => ['Files'],
            'order' => array('Files.created' => 'desc'),
            'limit' => 5
        );
        $this->set('users', $this->paginate('Users'));
    }

    public function view($id)
    {
        if (!$id) {
            $this->Flash->warning(__('Invalid user.'));
            $this->redirect(['controller'=>'users','action'=>'profile']);
        }
        $user = $this->Users->safeRead(['Users.id'=>$id]);
        $this->loadModel('GintonicCMS.Files');
        $avatar ='/' . $this->Files->getUrl('',$user->file_id);
        $this->set(compact('user','avatar'));
    }

    public function add()
    {
        if($this->request->session()->read('Auth.User.role') != 'admin'){
            $this->Flash->warning(__('You don\'t have permission to add user'));
            $this->redirect(array('controller'=>'users','action'=>'profile'));
        }
        $this->request->data["validated"] = 1;
        $user = $this->Users->newEntity($this->request->data);
        if ($this->request->is('post')) {
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }
    
    public function edit($userId = 0) {
        if (!$userId) {
            $this->Flash->warning(__('Invalid user'));
            return $this->redirect($this->request->referer());
        }
        $user = $this->Users->find()
                    ->where(['Users.id'=>$userId])
                    ->contain(['Files'])
                    ->first();
        //$user = $this->Users->get($userId);
        $avatar ='';
        if(!empty($user->file)){
            $avatar = '/files/uploads/' . $user->file->filename;
        }
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('User has been updated.'));
                if($this->request->session()->read('Auth.User.role') == 'admin'){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'profile']);
                }
            }
            $this->Flash->warning(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user','avatar'));
        $this->render('/Users/edit_avatar');
    }
    
    public function update_avatar($userId = null, $fileId =null)
    {
        if (!empty($this->request->data['id'])) {
            $userId = $this->request->data['id'];
        }
        if (!empty($this->request->data['file_id'])) {
            $fileId = $this->request->data['file_id'];
        }
        $user = $this->Users->safeRead(['Users.id'=>$userId]);
        if(!empty($user->file_id)){
            $oldFile = $user->file_id;
        }
        $user->file_id = $this->request->data['file_id'];
        if ($this->Users->save($user)) {
            $this->loadModel('GintonicCMS.Files');
            if(!empty($oldFile)){
                $file = $this->Files->get($oldFile);
                $this->Files->deleteFile($file->filename,$file->id);
            }
            $file = $this->Files->get($fileId);
            echo json_encode(array(
                    'message' => __('Profile photo has been change successfully.'),
                    'success' => True,
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

    public function signup()
    {
        if (!empty($this->Auth->user())) {
            $this->Flash->warning(__('You are already Loggedin.'));
            return $this->redirect($this->Auth->redirectUrl());
        }
        $user = $this->Users->newEntity($this->request->data);
        if ($this->request->is(['post','put'])) {
            if ($this->Users->save($user)) {
                $this->Users->signupMail($this->request->data['email']);
                $this->Flash->success(__('Please check your e-mail to validate your account'));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->warning(__('Error creating your account, please contact an administrator'));
        }
        $this->set('user', $user);
    }

    public function signin()
    {
        if (!empty($this->Auth->user())) {
            $this->Message->setWarning(__('You are already Loggedin.'));
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
                }
                $this->Auth->setUser($user);
                if (isset($this->request->data['remember'])) {
                    $this->GtwCookie->rememberMe($this->request->session()->read('Auth'));
                }
                // User needs to be validated
                $this->Flash->success(__('Login successfull.'));
                if(empty($user['validated'])){
                    $this->Flash->success(__('Login successfull.Please validate your email address'));
                }
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }
    
    public function signout()
    {
        if (empty($this->Auth->user())) {
            $this->Flash->warning(__('You are not login.'));
            return $this->redirect($this->Auth->logout());
        }
        $this->GtwCookie->forgetMe();
        $this->Flash->success(__('You are now logged out.'));
        return $this->redirect($this->Auth->logout());
    }
    
    function profile() 
    {
        
    }
    
    public function confirmation($userId = null, $token = null) {
        if ($userId || $token) {
            $user = $this->Users->safeRead(['id'=>$userId]);
            if (!empty($user['validated'])) {
                $this->Flash->warning(__('Your email address is already validated, please use email and password to login'));
                return $this->redirect($this->Auth->redirectUrl());
            } elseif (!empty($user)) {
                $user = $this->Users->confirmation($userId, $token);
                $this->Auth->setUser($user->toArray());
                $this->Flash->success(__('Email address successfuly validated'));
                return $this->redirect(['plugin'=>'GintonicCMS','controller'=>'users','action'=>'profile']);
            } else {
                $this->Flash->warning(__('The authorization link provided is erroneous, please contact an administrator'));
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        $this->Flash->warning(__('Please check your e-mail for validation link'));
        return $this->redirect($this->Auth->redirectUrl());
    }
    
    public function change_password()
    {
        if (!empty($this->request->data)) {
            $userDetail = $this->Users->get($this->request->session()->read('Auth.User.id'));
            if ($this->request->data['new_password'] != $this->request->data['confirm_password']) {
                $this->Flash->warning(__('Confirm Password entered does not match.'));
            } elseif ($this->request->data['new_password'] == "") {
                $this->Flash->warning(__('New Password Must Not Blank'));
            } else {
                $this->request->data['id'] = $this->request->session()->read('Auth.User.id');
                $this->request->data['password'] = $this->request->data['new_password'];
                $users = $this->Users->patchEntity($userDetail,$this->request->data);
                //$users = $this->Users->newEntity($this->request->data);
                if ($this->Users->save($users)) {
                    $this->Flash->success(__('Password has been updated Successfully.'));
                    $this->redirect(array('controller'=>'users','action' => 'profile'));
                } else {
                    $this->Flash->warning(__('Unable to Change Password, Please try again.'));
                }
            }
        }
    }
    
    public function reset_password($userId = null, $token = null) 
    {
        if ($userId && $token) {
            $arrResponse = $this->Users->checkForgotPassword($userId, $token);
            if ($arrResponse['status'] == 'fail') {
                $this->Flash->warning($arrResponse['message']);
                return $this->redirect($this->Auth->redirectUrl());
            }
        } else {
            $this->Flash->warning(__($arrResponse['message']));
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->set(compact('userId', 'token'));
        if ($this->request->is(['post','put'])) {
            if ($this->request->data['new_password'] != $this->request->data['confirm_password']) {
                $this->Flash->warning(__('New Password and Confirm Password must be same'));
            } else {
                $this->request->data['id'] = $userId;
                $this->request->data['password'] = $this->request->data['new_password'];
                $this->request->data['token'] = md5(uniqid(rand(), true));
                $this->request->data['token_creation'] = date("Y-m-d H:i:s");
                $users = $this->Users->newEntity($this->request->data);
                $this->Users->save($users);
                $this->Flash->success(__('Your password has been updated successfully'));
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }
    
    public function resend_verification() 
    {
        if ($this->request->is(['post','put'])) {
            $arrResponse = $this->Users->ResendVerification($this->request->data['email']);
            if (!empty($arrResponse)) {
                if ($arrResponse['status'] == 'fail') {
                    $this->Flash->warning($arrResponse['message']);
                } else {
                    $this->Flash->success($arrResponse['message']);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
    }
    
    public function forgot_password() 
    {
        //Check For Already Logged In
        if ($this->Auth->user()) {
            $this->Flash->warning(__('You are already login.'));
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is(['post','put'])) {
            $arrResponse = $this->Users->ForgotPasswordEmail($this->request->data['email']);
            if (!empty($arrResponse)) {
                if ($arrResponse['status'] == 'fail') {
                    $this->Flash->warning($arrResponse['message']);
                } else {
                    $this->Flash->success($arrResponse['message']);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
    }
    
    public function delete($id = null) 
    {
        if (empty($this->Auth->user())) {
            $this->Flash->warning(__('You are not login.'));
            return $this->redirect($this->Auth->redirectUrl());
        }
        $user = $this->Users->get($id);
        if (!$user) {
            $this->Flash->warning(__('Invalid user'));
            return $this->redirect($this->request->referer());
        }
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Users deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->warning(__('Users was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

    function isAuthorized($user) 
    {
        if (!empty($user)) {
            if ($user['role'] == 'admin') {
                $this->layout = 'admin';
            }
            return true;
        } else {
            return false;
        }
    }
    
}

?>
