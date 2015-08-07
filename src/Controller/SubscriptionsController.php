<?php
namespace GintonicCMS\Controller;

use GintonicCMS\Controller\AppController;

/**
 * Subscriptions Controller
 *
 * @property \GintonicCMS\Model\Table\SubscriptionsTable $Subscriptions
 */
class SubscriptionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Plans', 'Customers']
        ];
        $this->set('subscriptions', $this->paginate($this->Subscriptions));
        $this->set('_serialize', ['subscriptions']);
    }

    /**
     * View method
     *
     * @param string|null $id Subscription id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subscription = $this->Subscriptions->get($id, [
            'contain' => ['Plans', 'Customers']
        ]);
        $this->set('subscription', $subscription);
        $this->set('_serialize', ['subscription']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subscription = $this->Subscriptions->newEntity();
        if ($this->request->is('post')) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->data);
            if ($this->Subscriptions->save($subscription)) {
                $this->Flash->success(__('The subscription has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
            }
        }
        $plans = $this->Subscriptions->Plans->find('list', ['limit' => 200]);
        $customers = $this->Subscriptions->Customers->find('list', ['limit' => 200]);
        $this->set(compact('subscription', 'plans', 'customers'));
        $this->set('_serialize', ['subscription']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Subscription id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subscription = $this->Subscriptions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->data);
            if ($this->Subscriptions->save($subscription)) {
                $this->Flash->success(__('The subscription has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
            }
        }
        $plans = $this->Subscriptions->Plans->find('list', ['limit' => 200]);
        $customers = $this->Subscriptions->Customers->find('list', ['limit' => 200]);
        $this->set(compact('subscription', 'plans', 'customers'));
        $this->set('_serialize', ['subscription']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscription id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscription = $this->Subscriptions->get($id);
        if ($this->Subscriptions->delete($subscription)) {
            $this->Flash->success(__('The subscription has been deleted.'));
        } else {
            $this->Flash->error(__('The subscription could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
