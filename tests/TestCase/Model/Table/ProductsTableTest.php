<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsTable;
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

    public $fixtures = ['app.Products'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Products') ? [] : ['className' => ProductsTable::class];
        $this->Products = $this->getTableLocator()->get('Products', $config);
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
        // $this->markTestIncomplete('Not implemented yet.');
        $product = $this->Products->newEntity([
            'name' => 'Test Product',
            'quantity' => 5,
            'price' => 20
        ]);
        $this->assertEmpty($product->getErrors());

        $product = $this->Products->newEntity([
            'name' => '',
            'quantity' => -1,
            'price' => 20000
        ]);
        $this->assertNotEmpty($product->getErrors());
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
