<?php
declare(strict_types=1);

namespace App\Controller;

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
        // $query = $this->Products->find();

        $this->paginate = [
            'conditions' => ['Products.deleted' => 0],
            'limit' => 10,
        ];

        if ($this->request->is('get')) {
            $status = $this->request->getQuery('status');
            $search = $this->request->getQuery('search');
            if ($status) {
                $this->paginate['conditions']['Products.status'] = $status;
            }
            if ($search) {
                $this->paginate['conditions']['Products.name LIKE'] = '%' . $search . '%';
            }
        }

        // $products = $this->paginate($query);
        $products = $this->paginate($this->Products);
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
        // $product = $this->Products->get($id, contain: []);
        $product = $this->Products->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product was not updated. Please, try again.'));
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        // Soft delete
        $product->deleted = true;
        if ($this->Products->save($product)) {
            $this->Flash->success(__('Product has been deleted.'));
        } else {
            $this->Flash->error(__('Unable to delete product'));
        }
        // if ($this->Products->delete($product)) {
        //     $this->Flash->success(__('The product has been deleted.'));
        // } else {
        //     $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        // }

        return $this->redirect(['action' => 'index']);
    }
}
