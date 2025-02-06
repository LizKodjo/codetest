<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $statusFilter = $this->request->getQuery('status');
        $searchTerm = $this->request->getQuery('search');

        $query = $this->Products->find('all')
            ->where(['deleted' => false]);

        if ($statusFilter) {
            $query->where(['status' => $statusFilter]);
        }

        if ($searchTerm) {
            $query->andWhere(['name LIKE' => "%$searchTerm%"]);
        }

        // Apply filters

        $products = $this->paginate($query);
        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, contain: []);
        $this->set(compact('product'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $product = $this->Products->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Product not found');

            return $this->redirect(['action' => 'index']);
        }

        // $product = $this->Products->get($id, contain: []);
        // if ($this->request->is(['patch', 'post', 'put'])) {
        if ($this->request->is(['post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        try {
            $product = $this->Products->get($id);
            $product->deleted = true;
            if ($this->Products->save($product)) {
                $this->Flash->success('Product has been deleted.');
            } else {
                $this->Flash->error('Unable to delete the product.');
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Product not found.');
        }

        return $this->redirect(['action' => 'index']);
    }
}
