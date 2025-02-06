<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductsTable Test Case
 */
class ProductsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductsTable
     */
    protected $Products;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    // protected array $fixtures = [
    //     'app.Products',
    // ];

    protected array $fixtures = ['app.Products'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Products') ? [] : ['className' => ProductsTable::class];
        $this->Products = TableRegistry::getTableLocator()->get('Products', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Products);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        // Check validations
        $product = $this->Products->newEmptyEntity();
        $product->name = 'Test Product';
        $product->quantity = 5;
        $product->price = 50;

        $errors = $this->Products->getValidator($product);
        $this->assertEmpty($errors, 'Validation errors should be empty');

        $product->name = 'T';
        $errors = $this->Products->getValidator($product);
        $this->assertNotEmpty($errors, 'Product name should be between 3 and 50 characters.');

        $product->name = 'A valid name';
        $product->price = -1;
        $errors = $this->Products->getValidator($product);
        $this->assertNotEmpty($errors, 'Price must be greater than 0.');

        $product->price = 150;
        $product->quantity = 5;
        $errors = $this->Products->validate($product);
        $this->assertNotEmpty($errors, 'Products with price > 100 must have a minimum quantity of 10');

        $product->name = 'promo-code';
        $product->price = 60;
        $errors = $this->Products->validate($product);
        $this->assertNotEmpty($errors, 'Products with "promo" must have a price less than 50');
    }

    public function testCalculateStatus()
    {
        // Status calculation
        $inStock = $this->Products->calculateStatus(15);
        $this->assertEquals('in stock', $inStock);

        $lowStock = $this->Products->calculateStatus(5);
        $this->assertEquals('low stock', $lowStock);

        $outOfStock = $this->Products->calculateStatus(0);
        $this->assertEquals('out of stock', $outOfStock);
    }

    public function testSaveProduct()
    {
        $product = $this->Products->newEntity([
            'name' => 'Test Product',
            'quantity' => 20,
            'price' => 50,
        ]);
        $savedProduct = $this->Products->save($product);
        $this->assertNotEmpty($savedProduct->last_updated, 'last_updated field should be populated');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     * @uses \App\Model\Table\ProductsTable::beforeSave()
     */
    public function testBeforeSave(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
