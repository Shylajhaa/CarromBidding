<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Players Model
 *
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\TeamsTable|\Cake\ORM\Association\BelongsTo $Teams
 * @property \App\Model\Table\BoardsTable|\Cake\ORM\Association\BelongsToMany $Boards
 *
 * @method \App\Model\Entity\Player get($primaryKey, $options = [])
 * @method \App\Model\Entity\Player newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Player[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Player|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Player|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Player patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Player[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Player findOrCreate($search, callable $callback = null, $options = [])
 */
class PlayersTable extends Table
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

        $this->setTable('players');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Teams', [
            'foreignKey' => 'team_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Boards', [
            'foreignKey' => 'player_id',
            'targetForeignKey' => 'board_id',
            'joinTable' => 'boards_players'
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
            ->scalar('image_url')
            ->maxLength('image_url', 255)
            ->requirePresence('image_url', 'create')
            ->notEmpty('image_url');

        $validator
            ->integer('base_points')
            ->requirePresence('base_points', 'create')
            ->notEmpty('base_points');

        $validator
            ->integer('bid_value')
            ->requirePresence('bid_value', 'create')
            ->notEmpty('bid_value');
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['team_id'], 'Teams'));

        return $rules;
    }

    public function getRandomNumber($basePoints)
    {
        // echo $basePoints;
        $players = TableRegistry::get('Players');

        $query = $players->find();
        $players = $query->select(['id'])
                         ->where(['base_points' => $basePoints,'team_id IS NULL'])
                         ->all();
                
        echo count($players);

        if(count($players) != 0)
        {
            echo "not zero";
            $ids = [];
            $i = 0;
            foreach ($players as $player) 
            {
                echo "hi";
                $ids[$i] = $player->id;
                $i++;    
            }
            $randomId = array_rand($ids);
            return $ids[$randomId];  
        } 
        return 0; 
        // return $players;
    }

    public function mapPlayerToTeam($playerId,$teamId,$bidPoints)
    {
          $players = TableRegistry::get("Players");
          $player = $players->get($playerId);
          if($bidPoints != 0)
          {
              $data = ['team_id' => $teamId, 'bid_value' => $bidPoints];
          }
          else
          {
              $data = ['team_id' => $teamId];  
          }
          $player = $players->patchEntity($player, $data, ['validate' => false]);
          if ($players->save($player)) 
          {
              echo "successfully mapped player to team";
          } 
    }

    public function validateBid($playerId,$teamId,$current_bid_points,$bid_points,$player_base_points)
    {
          $teams = TableRegistry::get("Teams");

          if($bid_points <= $current_bid_points)
          {
              echo "bid points greater";
              $players = TableRegistry::get("Players");

              $fetchData['conditions'] = array('base_points' => 25);
              $playersWith25 = count($players->find('all')
                                 ->where(['players.base_points' => 25,'players.team_id' => $teamId])
                                 ->contain(['Teams'])
                                 ->toArray());

              $playersWith15 =  count($players->find('all')
                                 ->where(['players.base_points' => 15,'players.team_id' => $teamId])
                                 ->contain(['Teams'])
                                 ->toArray()); 

              if($playersWith25 < 2)
              {
                  if($playersWith15 < 3)
                  {
                      return true;
                  }
              }   
          }
          return false;
    }

    public function updatePlayerBasePoints()
    {
        $players = TableRegistry::get("Players");
        $players = $players->find('all')
                           ->where(['team_id IS NULL']);

        foreach ($players as $player) 
        {
            $data = ['base_points' => 15];  
            $player = $players->patchEntity($player, $data, ['validate' => false]);
            if ($players->save($player)) 
            {
                echo "successfully mapped player to team";
            }      
        }    
    }

    public function checkIfPlayersAreSold()
    {
        $players = TableRegistry::get("Players");
        $teams = TableRegistry::get("Teams");

        $teams = $teams->find('all')
                              ->contain(['Players'])
                              ->toArray();
        $validTeams = array();
        $countTeam = 0;
        foreach ($teams as $team) 
        {
            $playersCount = array();
            $count_25 = 0;
            $count_15 = 0;
            foreach ($team->players as $player) 
            {
                if($player->base_points == 25)
                {
                    $count_25++;
                }
                if($player->base_points == 15)
                {
                    $count_15++;
                }
            }

            if($count_25 ==2 && ($count_15 + $count_25) < 4)
            {
                $countTeam++;
            }  
        }
        if($countTeam == count($teams))
        {
            return true;
        }
        return false;
    }

}
