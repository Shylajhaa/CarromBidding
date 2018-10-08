<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MatchesFixture
 *
 */
class MatchesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'team1_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'team2_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'stage_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'winner' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'team1_points' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'team2_points' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'refree' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'start_time' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'refree' => ['type' => 'index', 'columns' => ['refree'], 'length' => []],
            'stage_id' => ['type' => 'index', 'columns' => ['stage_id'], 'length' => []],
            'team1_id' => ['type' => 'index', 'columns' => ['team1_id'], 'length' => []],
            'team2_id' => ['type' => 'index', 'columns' => ['team2_id'], 'length' => []],
            'winner' => ['type' => 'index', 'columns' => ['winner'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'matches_ibfk_1' => ['type' => 'foreign', 'columns' => ['refree'], 'references' => ['users', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'matches_ibfk_2' => ['type' => 'foreign', 'columns' => ['stage_id'], 'references' => ['stages', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'matches_ibfk_3' => ['type' => 'foreign', 'columns' => ['team1_id'], 'references' => ['teams', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'matches_ibfk_4' => ['type' => 'foreign', 'columns' => ['team2_id'], 'references' => ['teams', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'matches_ibfk_5' => ['type' => 'foreign', 'columns' => ['winner'], 'references' => ['teams', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
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
                'team1_id' => 1,
                'team2_id' => 1,
                'stage_id' => 1,
                'winner' => 1,
                'team1_points' => 1,
                'team2_points' => 1,
                'refree' => 1,
                'start_time' => 1538983708
            ],
        ];
        parent::init();
    }
}
