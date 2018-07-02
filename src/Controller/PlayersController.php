<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;

/**
 * Players Controller
 *
 * @property \App\Model\Table\PlayersTable $Players
 *
 * @method \App\Model\Entity\Player[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlayersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // $this->paginate = [
        //     'contain' => ['Roles', 'Teams']
        // ];
        $players = $this->paginate($this->Players);
        // $data = json_decode('players');
        // $this->set(compact('players'));
        // $data = json_encode($data['players']);
        // $json = Set::extract('/players/.', $json);
       // $this->set('players',$players);
        // $this->response->type('json');
        // $this->response->body($players);
        //  $this->set('_serialize',true);
        // return $this->response;
       // $this->response->type('application/json');
       // $this->response->body(json_encode($players));
       // return $this->response;
//         $this->set(array(
//     'players' => $players,
//     '_serialize' => 'players'
// ));
       $this->allowCrossOrigin();
       $this->set(compact('players'));
       $this->set('_serialize',true);
    }

    /**
     * View method
     *
     * @param string|null $id Player id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $player = $this->Players->get($id);
        $this->allowCrossOrigin();
        $this->set('player', $player);
        $this->set('_serialize',true);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $player = $this->Players->newEntity();
        if ($this->request->is('post')) {
            $player = $this->Players->patchEntity($player, $this->request->getData());
            $player->team_id = null;
            $player->bid_value = 0;
            if ($this->Players->save($player)) {
                $this->Flash->success(__('The player has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The player could not be saved. Please, try again.'));
        }
        // $roles = $this->Players->Roles->find('list', ['limit' => 200]);
        // $teams = $this->Players->Teams->find('list', ['limit' => 200]);
        // $boards = $this->Players->Boards->find('list', ['limit' => 200]);
        $this->allowCrossOrigin();
        $this->set("_serialize",true);
        $this->set(compact('player'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Player id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $data=$this->request->input('json_decode');
        $player = $this->Players->get($id, [
            'contain' => ['Boards']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $player = $this->Players->patchEntity($player, $this->request->getData(), ['validate' => false]);
            if ($this->Players->save($player)) {
                $this->Flash->success(__('The player has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The player could not be saved. Please, try again.'));
        }
        // $roles = $this->Players->Roles->find('list', ['limit' => 200]);
        // $teams = $this->Players->Teams->find('list', ['limit' => 200]);
        // $boards = $this->Players->Boards->find('list', ['limit' => 200]);
        // $this->set(compact('player', 'roles', 'teams', 'boards'));
        $this->allowCrossOrigin();
        $this->set("player",$player);
        $this->set("_serialize",true);
    }

    /**
     * Delete method
     *
     * @param string|null $id Player id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $player = $this->Players->get($id);
        if ($this->Players->delete($player)) {
            $this->Flash->success(__('The player has been deleted.'));
        } else {
            $this->Flash->error(__('The player could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function allowCrossOrigin()
    {
       $this->response->header('Access-Control-Allow-Origin','*');
       $this->response->header('Access-Control-Allow-Methods','*');
       $this->response->header('Access-Control-Allow-Headers','X-Requested-With');
       $this->response->header('Access-Control-Allow-Headers','Content-Type, x-xsrf-token');
       $this->response->header('Access-Control-Max-Age','172800');
    }

    public function getRandomPlayer()
    {
        $data=$this->request->input('json_decode');

        $players = TableRegistry::get("Players");
        $playersCount = count($players->find('all')
                                 ->where(['team_id' => null,'base_points' => 25])
                                 ->toArray());

        if($playersCount > 0)
        {
            $id = $this->Players->getRandomNumber(25);
        }
        else
        {
            $id = $this->Players->getRandomNumber(15);    
        }
        
        $player = TableRegistry::get("Players")
                ->find()
                ->where(['id' => $id]);

        $this->allowCrossOrigin();
        $this->set("player",$player);
        $this->set("_serialize",true);
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

    public function bidPlayer($playerId)
    {
        $data=$this->request->input('json_decode');

        if($this->request->is(['post','patch','put']))
        {
            $team_name = $this->request->data['name'];
            $bid_points = $this->request->data['bidPoints'];

            $teams = TableRegistry::get("Teams");
            $team_id = $this->getTeamId($team_name);
            $players = TableRegistry::get("Players");

            $team = $teams->get($team_id);

            $current_bid_points = $team->get('bid_points');

            $query = $players->find();
            $player = $query->select(['base_points'])
                      ->where(['id' => $playerId])
                      ->toArray();
            $player_base_points = $player[0]['id'];

            if($this->Players->validateBid($playerId,$team_id,$current_bid_points,$bid_points,$player_base_points))
            {
                echo "valid";
                $team = $this->updateTeamPoints($team_id,$bid_points,$current_bid_points);

                $this->Players->mapPlayerToTeam($playerId,$team_id,$bid_points);
            }
        }
        else
        {
            throw new \Exception("Error Processing Request", 1);
        }

        $this->allowCrossOrigin();
        $this->set("team",$team);
        $this->set("_serialize",true);     
    }

    public function updateTeamPoints($teamId,$bidPoints,$current_bid_points)
    {
          $teams = TableRegistry::get("Teams");

          $team = $teams->get($teamId);

          $data = ['bid_points' => ($current_bid_points - $bidPoints)];
          $team = $teams->patchEntity($team, $data, ['validate' => false]);
          if ($teams->save($team)) 
          {
              $this->Flash->success(__('The player has been saved.'));
          } 
          return $team;
    }

    public function getPlayersTeamWise()
    {
        $players = TableRegistry::get("Players");
        $players = $players->find('all')
                           ->contain(['Teams']);

        $this->allowCrossOrigin();
        $this->set("players",$players);
        $this->set("_serialize",true);
    }
}
