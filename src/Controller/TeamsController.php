<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;

use Cake\Collection\Collection;

/**
 * Teams Controller
 *
 * @property \App\Model\Table\TeamsTable $Teams
 *
 * @method \App\Model\Entity\Team[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TeamsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $teams = $this->paginate($this->Teams);

        // $this->set(compact('teams'));
        $this->allowCrossOrigin();
        $this->set("teams",$teams);
        $this->set("_serialize",true);
    }

    /**
     * View method
     *
     * @param string|null $id Team id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $team = $this->Teams->get($id);

        $this->allowCrossOrigin();
        $this->set('team', $team);
        $this->set('_serialize',true);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $team = $this->Teams->newEntity();
        if ($this->request->is('post')) {
            $bidder = $this->request->getData('player');
            $team = $this->Teams->patchEntity($team, $this->request->getData());
            $team->bid_points = 100;
            $team->played = 0;
            $team->won = 0;
            $team->points = 0;
            $team->loss = 0;
            
            if ($this->Teams->save($team)) {
                $this->Flash->success(__('The team has been saved.'));

                // return $this->redirect(['action' => 'index']);
                $teamId = $team->id;
                $this->Teams->Players->mapPlayerToTeam($bidder,$teamId,0);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        $this->allowCrossOrigin();
        $this->set(compact('team'));
        $this->set("team",$team);
        $this->set("_serialize",true);
    }

    /**
     * Edit method
     *
     * @param string|null $id Team id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $team = $this->Teams->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $team = $this->Teams->patchEntity($team, $this->request->getData());
            if ($this->Teams->save($team)) {
                $this->Flash->success(__('The team has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        $this->allowCrossOrigin();
        $this->set(compact('team'));
        $this->set("team",$team);
        $this->set("_serialize",true);
    }

    /**
     * Delete method
     *
     * @param string|null $id Team id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $team = $this->Teams->get($id);

        $players = TableRegistry::get("Players");
        $playersInTeam = $players->find('all')
                                 ->contain(['Teams'])
                                 ->where(['players.team_id' => $id]);
        foreach ($playersInTeam as $player) 
        {
            $data = ['team_id' => null];  
            $player = $players->patchEntity($player, $data, ['validate' => false]);
            if ($players->save($player)) 
            {
                echo "successfully mapped player to team";
            }         
        }
        if ($this->Teams->delete($team)) {
            $this->Flash->success(__('The team has been deleted.'));
        } else {
            $this->Flash->error(__('The team could not be deleted. Please, try again.'));
        }
        $teams = TableRegistry::get("Teams");
        $teams = $teams->find('all');
        $this->set("teams",$teams);
        $this->set("_serialize",true);
    }

    public function allowCrossOrigin()
    {
       $this->response->header('Access-Control-Allow-Origin','*');
       $this->response->header('Access-Control-Allow-Methods','*');
       $this->response->header('Access-Control-Allow-Headers','X-Requested-With');
       $this->response->header('Access-Control-Allow-Headers','Content-Type, x-xsrf-token');
       $this->response->header('Access-Control-Max-Age','172800');
    }


    public function getTeamsWithPlayers()
    {
        $teams =  TableRegistry::get("Teams"); 
        $teams = $teams->find('all')
                       ->contain(['Players'])
                       ->group('teams.id');

        $this->allowCrossOrigin();
        $this->set("teams",$teams);
        $this->set("_serialize",true);
    }

    public function getValidTeams($player_base_points = 25)
    {
        $players = TableRegistry::get("Players");
        $teams = TableRegistry::get("Teams");

        $teams = $teams->find('all')
                              ->contain(['Players'])
                              ->toArray();
        $validTeams = array();
        foreach ($teams as $team) {
            $playersCount = array();
            $count_25 = 0;
            $count_15 = 0;
            foreach ($team->players as $player) {
                if($player->base_points == 25)
                {
                    $count_25++;
                }
                if($player->base_points == 15)
                {
                    $count_15++;
                }
            }
            if(($count_25 < 2 || $count_15 < 3) && ($count_25 + $count_15) < 4)
            {
                array_push($validTeams,$team);
            }
        }


        $this->allowCrossOrigin();
        // $this->set("teamCount",$players);
        $this->set("teams",$validTeams);
        $this->set("_serialize",true);

    }
}
