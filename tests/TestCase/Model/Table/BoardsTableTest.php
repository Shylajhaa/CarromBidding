<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BoardsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BoardsTable Test Case
 */
class BoardsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BoardsTable
     */
    public $Boards;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.boards',
        'app.matches',
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
        $config = TableRegistry::getTableLocator()->exists('Boards') ? [] : ['className' => BoardsTable::class];
        $this->Boards = TableRegistry::getTableLocator()->get('Boards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Boards);

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
