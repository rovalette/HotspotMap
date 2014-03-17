<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 10/03/2014
 * Time: 18:51
 */

namespace HotspotMap\Entity;


use Symfony\Component\Validator\Constraints\Date;

class Hotspot {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $userId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $address;

    /**
     * @var boolean
     */
    public $hasPlugs;

    /**
     * @var boolean
     */
    public $hasCoffee;

    /**
     * @var boolean
     */
    public $hasWifi;

    /**
     * @var date
     */
    public $date;

    /**
     * @param integer $userId
     * @param string $name
     * @param string $address
     * @param string $date
     * @param integer null $id
     */
    public function __construct($userId, $name, $address, $date, $id = null)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->address = $address;
        $this->date = $date;
        $this->id = $id;
    }
}
