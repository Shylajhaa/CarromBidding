<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BoardsPlayer Entity
 *
 * @property int $id
 * @property int $board_id
 * @property int $player_id
 * @property int $coins
 * @property int $opc
 * @property int $minus
 *
 * @property \App\Model\Entity\Board $board
 * @property \App\Model\Entity\Player $player
 */
class BoardsPlayer extends Entity
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
        'board_id' => true,
        'player_id' => true,
        'coins' => true,
        'opc' => true,
        'minus' => true,
        'board' => true,
        'player' => true
    ];
}
