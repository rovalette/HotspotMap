<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 15/02/2014
 * Time: 12:35
 */

require_once __DIR__.'/../vendor/autoload.php';

class UserTest extends PHPUnit_Framework_TestCase {

    public function testUser()
    {
        $firstname = 'John';
        $lastname = 'Doe';
        $username = 'johndoe';
        $password = '12345';
        $email = 'john.doe@email.com';

        $user = new \HotspotMap\Entity\User($firstname,$lastname,$username,$password,$email);

        $this->assertEquals($user->firstName,$firstname);
        $this->assertEquals($user->lastName,$lastname);
        $this->assertEquals($user->userName,$username);
        $this->assertEquals($user->password,$password);
        $this->assertEquals($user->email,$email);
    }

    public function testUserId()
    {
        $user = new \HotspotMap\Entity\User('John','Doe','johndoe','12345','john.doe@email.com');

        $user->id = 1;

        $this->assertEquals($user->id, 1);
    }
}
 