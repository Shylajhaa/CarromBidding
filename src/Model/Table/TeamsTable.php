<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Teams Model
 *
 * @property \App\Model\Table\PlayersTable|\Cake\ORM\Association\HasMany $Players
 *
 * @method \App\Model\Entity\Team get($primaryKey, $options = [])
 * @method \App\Model\Entity\Team newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Team[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Team|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Team|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Team patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Team[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Team findOrCreate($search, callable $callback = null, $options = [])
 */
class TeamsTable extends Table
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

        $this->setTable('teams');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Players', [
            'foreignKey' => 'team_id'
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('bid_points')
            ->requirePresence('bid_points', 'create')
            ->notEmpty('bid_points');

        $validator
            ->integer('played')
            ->requirePresence('played', 'create')
            ->notEmpty('played');

        $validator
            ->integer('won')
            ->requirePresence('won', 'create')
            ->notEmpty('won');

        $validator
            ->integer('points')
            ->requirePresence('points', 'create')
            ->notEmpty('points');

        $validator
            ->integer('loss')
            ->requirePresence('loss', 'create')
            ->notEmpty('loss');

        return $validator;
    }

    public function updateTeamPoints($teamId,$bidPoints,$current_bid_points)
    {
          echo $teamId." ".$bidPoints." ".$current_bid_points;
          $teams = TableRegistry::get("Teams");

          $team = $teams->get($teamId);

          $data = ['bid_points' => ($current_bid_points - $bidPoints)];
          $team = $teams->patchEntity($team, $data, ['validate' => false]);
          if ($teams->save($team)) 
          {
              // $this->Flash->success(__('The player has been saved.'));
            // $this->set("team",$team);
            // $this->set("_serialize",true);
            echo "succesfully updated teams bid points";
          } 
    }

    public function getTeamId($team_name)
    {
        $teams = TableRegistry::get("Teams");
        $query = $teams->find();
        $team = $query->select(['id'])
                      ->where(['name' => $team_name])
                      ->toArray();
        $team_id = $team[0]['id'];
        return $team_id;   
    }

}
