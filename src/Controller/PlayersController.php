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

        // $this->set(compact('players'));
        $this->set('players',$players);
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
        $player = $this->Players->get($id, [
            'contain' => ['Roles', 'Teams', 'Boards']
        ]);

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
        $player = $this->Players->get($id, [
            'contain' => ['Boards']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $player = $this->Players->patchEntity($player, $this->request->getData());
            if ($this->Players->save($player)) {
                $this->Flash->success(__('The player has been saved.'));

                // return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The player could not be saved. Please, try again.'));
        }
        // $roles = $this->Players->Roles->find('list', ['limit' => 200]);
        // $teams = $this->Players->Teams->find('list', ['limit' => 200]);
        // $boards = $this->Players->Boards->find('list', ['limit' => 200]);
        // $this->set(compact('player', 'roles', 'teams', 'boards'));
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

    public function getRandomNumber()
    {
        $players = TableRegistry::get('Players');

        $query = $players->find();
        $playerIds = $query->select(['id'])
                           ->where(['base_points' => 25]);

        // $this->set("playerIds",$playerIds);
        // $this->set("_serialize",true);

        $ids = [];
        $i = 0;
        foreach ($playerIds as $player) 
        {
            $ids[$i] = $player->id;
            $i++;    
            // echo $player->id;
        }
        $randomId = array_rand($ids);
        return $ids[$randomId];    
    }

    public function getRandomPlayer($basePoints = 25)
    {
        $data=$this->request->input('json_decode');

        $id = $this->getRandomNumber();
        echo $id;
        
        $playersTable = TableRegistry::get('Players');
        $player = TableRegistry::get("Players")
                ->find()
                ->where(['id' => $id]);

        $this->set("player",$player);
        $this->set("_serialize",true);
    }
}
