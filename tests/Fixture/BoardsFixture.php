<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BoardsFixture
 *
 */
class BoardsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'queen' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'finisher' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'team1_points' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'team2_points' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'match_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'match_id' => ['type' => 'index', 'columns' => ['match_id'], 'length' => []],
            'queen' => ['type' => 'index', 'columns' => ['queen'], 'length' => []],
            'finisher' => ['type' => 'index', 'columns' => ['finisher'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'boards_ibfk_1' => ['type' => 'foreign', 'columns' => ['match_id'], 'references' => ['matches', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'boards_ibfk_2' => ['type' => 'foreign', 'columns' => ['queen'], 'references' => ['players', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'boards_ibfk_3' => ['type' => 'foreign', 'columns' => ['finisher'], 'references' => ['players', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'queen' => 1,
                'finisher' => 1,
                'team1_points' => 1,
                'team2_points' => 1,
                'match_id' => 1
            ],
        ];
        parent::init();
    }
}
