<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
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
                'last_updated' => 1738771850,
                'created' => 1738771850,
                'modified' => 1738771850,
            ],
        ];
        parent::init();
    }
}
