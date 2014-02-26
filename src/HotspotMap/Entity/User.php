<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 14/02/2014
 * Time: 17:44
 */

namespace HotspotMap\Entity;


class User {
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $userName;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $email;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $userName
     * @param string $password
     * @param string $email
     * @param integer|null $id
     */
    public function __construct($firstName, $lastName, $userName, $password, $email, $id = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $userName;
        $this->password = $password;
        $this->email = $email;
        $this->id = $id;
    }
} 