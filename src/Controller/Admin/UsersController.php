<?php
namespace GintonicCMS\Controller\Admin;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use GintonicCMS\Controller\AppController;

class UsersController extends AppController
{
    /**
     * TODO: blockquote
     */
    public function beforeFilter(Event $event)
    {
        $this->layout = 'default';
    }

    /**
     * TODO: blockquote
     */
    public function index()
    {
        $arrConditions = ['Users.role <> ' => 'admin'];
        $this->paginate = array(
            'conditions' => $arrConditions,
            'order' => array('Users.created' => 'desc'),
            'limit' => 5
        );
        $this->set('users', $this->paginate('Users'));
    }

    /**
     * TODO: blockquote
     */
    public function add()
    {
        $this->request->data["validated"] = 1;
        $user = $this->Users->newEntity($this->request->data);
        if ($this->request->is('post')) {
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
        }
        $this->set('user', $user);
    }

    /**
     * TODO: blockquote
     */
    public function edit($userId = 0)
    {
        $user = $this->Users->safeRead(['Users.id' => $userId], true);
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
        if (!empty($user)) {
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
}
