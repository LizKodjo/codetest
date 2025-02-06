<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'autoIncrement' => true],
        'name' => ['type' => 'string', 'length' => 50],
        'quantity' => ['type' => 'integer'],
        'price' => ['type' => 'decimal', 'length' => '10,2'],
        'status' => ['type' => 'string'],
        'last_updated' => ['type' => 'datetime'],
        'deleted' => ['type' => 'boolean'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ];

    public array $records = [
        ['name' => 'Product 1', 'quantity' => 15, 'price' => 100, 'status' => 'in stock', 'last_updated' => '2025-01-01 12:00:00', 'deleted' => false],
        ['name' => 'Product 2', 'quantity' => 5, 'price' => 30, 'status' => 'low stock', 'last_updated' => '2025-01-02 12:00:00', 'deleted' => false],
        ['name' => 'Product 3', 'quantity' => 0, 'price' => 10, 'status' => 'out of stock', 'last_updated' => '2025-01-03 12:00:00', 'deleted' => false],
        ['name' => 'Product 3', 'quantity' => 150, 'price' => 500, 'status' => 'in stock', 'last_updated' => '2025-02-05 12:00:00', 'deleted' => false],
        ['name' => 'Pencils', 'quantity' => 55, 'price' => 200, 'status' => 'in stock', 'last_updated' => '2025-01-28 12:00:00', 'deleted' => true],
        ['name' => 'Desk Lamp', 'quantity' => 6, 'price' => 45, 'status' => 'low stock', 'last_updated' => '2025-01-27 12:00:00', 'deleted' => false],
        ['name' => 'Towels', 'quantity' => 0, 'price' => 25.50, 'status' => 'out of stock', 'last_updated' => '2025-02-06 12:00:00', 'deleted' => false],
        ['name' => 'Bandanges', 'quantity' => 100, 'price' => 10.99, 'status' => 'in stock', 'last_updated' => '2025-02-01 12:00:00', 'deleted' => false],
        ['name' => 'Arm chairs', 'quantity' => 24, 'price' => 250.99, 'status' => 'in stock', 'last_updated' => '2025-01-01 12:00:00', 'deleted' => false],
        ['name' => 'Irons', 'quantity' => 4, 'price' => 15.45, 'status' => 'low stock', 'last_updated' => '2025-01-01 12:00:00', 'deleted' => false],

    ];
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1,
                'price' => 1.5,
                'status' => 'Lorem ipsum dolor ',
                'deleted' => 1,
                'last_updated' => 1738777891,
                'created' => 1738777891,
                'modified' => 1738777891,
            ],
        ];
        parent::init();
    }
}
