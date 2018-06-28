<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Player Entity
 *
 * @property int $id
 * @property string $name
 * @property string $image_url
 * @property int $role_id
 * @property int $base_points
 * @property int $team_id
 * @property int $bid_value
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Team $team
 * @property \App\Model\Entity\Board[] $boards
 */
class Player extends Entity
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
        'name' => true,
        'image_url' => true,
        'role_id' => true,
        'base_points' => true,
        'team_id' => true,
        'bid_value' => true,
        'role' => true,
        'team' => true,
        'boards' => true
    ];
}
