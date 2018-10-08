<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BoardsPlayersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BoardsPlayersTable Test Case
 */
class BoardsPlayersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BoardsPlayersTable
     */
    public $BoardsPlayers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.boards_players',
        'app.boards',
        'app.players'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BoardsPlayers') ? [] : ['className' => BoardsPlayersTable::class];
        $this->BoardsPlayers = TableRegistry::getTableLocator()->get('BoardsPlayers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BoardsPlayers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertTrue(true);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->assertTrue(true);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->assertTrue(true);
    }
}
