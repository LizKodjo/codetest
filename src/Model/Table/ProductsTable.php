<?php
declare(strict_types=1);

namespace App\Model\Table;

// use Cake\ORM\Query\SelectQuery;
// use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @method \App\Model\Entity\Product newEmptyEntity()
 * @method \App\Model\Entity\Product newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Product> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Product findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Product> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Product> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator

            // ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Please enter a name')
            ->add('name', 'unique', [
                'rule' => 'isUnique',
                'message' => 'This product\'s name has already been saved',
            ])
            ->minLength('name', 3)
            ->maxLength('name', 50);

        $validator
            ->integer('quantity')
            ->greaterThanOrEqual('quantity', 0)
            ->lessThanOrEqual('quantity', 1000)
            ->notEmptyString('quantity');

        $validator
            ->decimal('price')
            ->greaterThan('price', 0)
            ->lessThanOrEqual('price', 10000)
            ->notEmptyString('price');

        $validator->add('quantity', 'min-quantity', [
            'rule' => function ($value, $context) {
                if ($context['data']['price'] > 100 && $value < 10) {
                    return false;
                }
                return true;
            },
            'message' => 'Products over 100 should have at least 10  in stock.',
        ]);

        $validator->add('price', 'promo-code', [
            'rule' => function ($value, $context) {
                if (strpos(strtolower($context['data']['name']), 'promo') !== false && $value >= 50) {
                    return false;
                }
                return true;
            },
            'message' => 'Products with "promo" code must be under 50.',
        ]);

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->notEmptyString('status');

        $validator
            ->boolean('deleted')
            ->notEmptyString('deleted');

        $validator
            ->dateTime('last_updated')
            ->notEmptyDateTime('last_updated');

        return $validator;
    }
}
