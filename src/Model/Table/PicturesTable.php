<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pictures Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Picture get($primaryKey, $options = [])
 * @method \App\Model\Entity\Picture newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Picture[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Picture|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Picture patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Picture[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Picture findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PicturesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('pictures');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Tags', [
            'foreignKey' => 'picture_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'pictures_tags'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('title');

        $validator
            ->allowEmpty('description');

        $validator
            ->requirePresence('path', 'create')
            ->notEmpty('path');

        return $validator;
	}

	/**
	 * The $query argument is a query builder instance.
	 * $options array contains the 'tags' option passed
	 * to find ('tagged') in our controller action
	 * */
	public function findTagged(Query $query, array $options)
	{
			return $this->find()
					->distinct(['Pictures.id'])
					->matching('Tags', function ($q) use ($options) {
							if(empty($options['tags'])){
									return $q->where(['Tags.title IS' => null]);
							}
							return $q->where(['Tags.title IN' => $options['tags']]);
					});
	}
}
