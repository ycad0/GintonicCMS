<?php
namespace GintonicCMS\Controller\Admin;

use Cake\Event\Event;
use GintonicCMS\Controller\AppController;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{
    public $paginate = [
        'limit' => 25,
        'order' => [
            'Users.created' => 'desc'
        ]
    ];

    /**
     * TODO: blockquote
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    /**
     * TODO: blockquote
     */
    public function index()
    {
        $aros = TableRegistry::get('Aros');
        $users = $this->Users->find() 
            ->contain(['Aros']);
        $users = $this->Users->bindRoles($this->paginate($users));
        $this->set('users', $users);
    }

    /**
     * TODO: blockquote
     */
    public function permissions()
    {
        $aros = TableRegistry::get('Aros');
        $roles = $aros->find()
            ->where(['alias IS NOT' => null])
            ->find('threaded')
            ->toArray();

        $acos = TableRegistry::get('Acos');
        $permissions = $acos->find()
            ->where(['alias IS NOT' => null])
            ->find('threaded')
            ->toArray();
        $this->set(compact('roles', 'permissions'));
    }

    /**
     * TODO: blockquote
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->newEntity($this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->set(__('The user has been saved successfully.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
                return $this->redirect([
                    'controller' => 'users',
                    'action' => 'index'
                ]);
            }
            $this->Flash->set(__('Unable to add user.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            $this->set('user', $user);
        }
    }

    /**
     * TODO: blockquote
     */
    public function edit($userId = 0)
    {
        $user = $this->Users->find('usersDetails', ['Users.id' => $userId]);
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->set(__('User has been updated.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->set(__('Error saving the user'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
        $this->set(compact('user'));
        $this->render('/Users/edit');
    }

    /**
     * TODO: blockquote
     */
    public function delete($id = null)
    {
        $user = $this->Auth->user();
        
        if (empty($user)) {
            $this->Flash->set(__('You are not signed in.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-warning']
            ]);
            return $this->redirect($this->Auth->redirectUrl());
        }
        $user = $this->Users->get($id);
        
        if (!$user) {
            $this->Flash->set(__('Invalid user'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect($this->request->referer());
        }
        if ($this->Users->delete($user)) {
            $this->Flash->set(__('Users deleted'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-success']
            ]);
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->set(__('Error deleting users'), [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => 'alert-danger']
        ]);
        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * TODO: write doccomment
     */
    public function profile()
    {
        $this->render('/Users/profile');
    }
    
    /**
     * TODO: write doccomment
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
}
