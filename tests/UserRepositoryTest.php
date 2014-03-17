<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 15/02/2014
 * Time: 15:24
 */

require_once __DIR__.'/../vendor/autoload.php';

class UserRepositoryTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \HotspotMap\Entity\User
     */
    protected $user1;

    /**
     * @var \HotspotMap\Entity\User
     */
    protected $user2;

    /**
     * @var \HotspotMap\Repository\UserRepository
     */
    protected $repo;

    public function setUp()
    {
        $dsn = 'mysql:host=localhost;dbname=testhotspotmap';

        $con = new \HotspotMap\Repository\Connection($dsn, 'root', 'root');

        $this->repo = new \HotspotMap\Repository\UserRepository($con);

        $this->user1 = new \HotspotMap\Entity\User('John','Smith','johnsmith','12345','john.smith@email.com');
        $this->user2 = new \HotspotMap\Entity\User('Jane','Doe','janedoe','67890','jane.doe@email.com');
    }

    public function testSave()
    {
        $this->assertTrue($this->repo->save($this->user1));
        $this->assertTrue($this->repo->save($this->user2));

        $this->assertFalse($this->repo->save($this->user1));
    }

    /**
     * @depends testSave
     */
    public function testCount()
    {
        $this->assertEquals($this->repo->count(), 2);
    }

    /**
     * @depends testCount
     */
    public function testFindAll()
    {
        $users = $this->repo->findAll();

        $this->assertTrue(count($users) != 0);
    }

    /**
     * @depends testFindAll
     */
    public function testFind()
    {
        $user = $this->repo->find(1);
        $this->assertNotNull($user);
        $this->assertEquals($user->id, 1);

        $user = $this->repo->find(100);
        $this->assertNull($user);
    }

    /**
     * @depends testFind
     */
    public function testDelete()
    {
        $this->assertTrue($this->repo->delete($this->user1->id));
        $this->assertNull($this->repo->find($this->user1->id));
    }
}
 