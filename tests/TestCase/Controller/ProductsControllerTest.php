<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProductsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProductsController Test Case
 *
 * @uses \App\Controller\ProductsController
 */
class ProductsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Products',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\ProductsController::index()
     */
    public function testIndex(): void
    {
        $this->get('/products');
        $this->assertResponseOk();
        $this->assertResponseContains('Products');
        // $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\ProductsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ProductsController::add()
     */
    public function testAdd(): void
    {
        $data = [
            'name' => 'New Product',
            'quantity' => 100,
            'price' => 99.99,
        ];

        $this->post('/products/add', $data);

        $this->assertResponseSuccess();
        $products = $this->getTableLocator()->get('Products');
        $product = $products->find()->where(['name' => 'New Product'])->first();
        $this->assertNotEmpty($product, 'Product should be save');
        // $this->markTestIncomplete('Not implemented yet.');
    }

    public function testAddInvalidData()
    {
        $data = [
            'name' => 'New Product',
            'quantity' => -1,
            'price' => 50,
        ];

        $this->post('/products/add', $data);

        $this->assertResponseError();
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\ProductsController::edit()
     */
    public function testEdit()
    {
        $product = $this->getTableLocator()->get('Products')->find()->first();

        $data = [
            'name' => 'Updated Product',
            'quantity' => 50,
            'price' => 75.00,
        ];

        $this->put("/products/edit/{$product->id}", $data);
        $this->assertResponseSuccess();

        // Check updated data
        $updatedProduct = $this->getTableLocator()->get('Products')->get($product->id);
        $this->assertEquals('Updated Product', $updatedProduct->name);
        $this->assertEquals(50, $updatedProduct->quantity);
        $this->assertEquals(75.00, $updatedProduct->price);
        // $this->markTestIncomplete('Not implemented yet.');
    }

    public function testEditInvalidData()
    {
        $product = $this->getTableLocator()->get('Products')->find()->first();
        $data = [
            'name' => 'Updated Product',
            'quantity' => -1,
            'price' => 75.00,
        ];

        $this->put("/products/edit/{$product->id}", $data);
        $this->assertResponseError();
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ProductsController::delete()
     */
    public function testDelete()
    {
        $product = $this->getTableLocator()->get('Products')->find()->first();

        $this->post("/products/delete/{$product->id}");
        $this->assertResponseSuccess();

        // Check soft delete
        $deletedProduct = $this->getTableLocator()->get('Products')->get($product->id);
        $this->assertTrue($deletedProduct->deleted, 'Product should be soft deleted');
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testDeleteInvalidId()
    {
        $this->post('/products/delete/9999');
        $this->assertResponseError();
    }
}
