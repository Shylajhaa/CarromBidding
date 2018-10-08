<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Board Entity
 *
 * @property int $id
 * @property int $queen
 * @property int $finisher
 * @property int $team1_points
 * @property int $team2_points
 * @property int $match_id
 *
 * @property \App\Model\Entity\Match $match
 * @property \App\Model\Entity\Player[] $players
 */
class Board extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'queen' => true,
        'finisher' => true,
        'team1_points' => true,
        'team2_points' => true,
        'match_id' => true,
        'match' => true,
        'players' => true
    ];
}
