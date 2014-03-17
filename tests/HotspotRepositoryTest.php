<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 16/03/2014
 * Time: 23:21
 */

class HotspotRepositoryTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \HotspotMap\Entity\User
     */
    protected $user;

    /**
     * @var \HotspotMap\Entity\Hotspot
     */
    protected $hp1;

    /**
     * @var \HotspotMap\Entity\Hotspot
     */
    protected $hp2;

    /**
     * @var \HotspotMap\Repository\UserRepository
     */
    protected $userRepo;

    /**
     * @var \HotspotMap\Repository\HotspotRepository
     */
    protected  $hotspotRepo;

    public function setUp()
    {
        $dsn = 'mysql:host=localhost;dbname=testhotspotmap';

        $con = new \HotspotMap\Repository\Connection($dsn, 'root', 'root');

        $this->userRepo = new \HotspotMap\Repository\UserRepository($con);
        $this->hotspotRepo = new \HotspotMap\Repository\HotspotRepository($con);

        $this->user = new \HotspotMap\Entity\User('John','Smith','johnsmith2','12345','john.smith2@email.com');
        $this->userRepo->save($this->user);
        $this->hp1 = new \HotspotMap\Entity\Hotspot($this->user->id,'ISIMA','Campus des Cézeaux, 63170 AUBIERE','16-03-2014');
        $this->hp1->hasCoffee = 1;
        $this->hp1->hasWifi = 1;
        $this->hp1->hasPlugs = 1;
        $this->hp2 = new \HotspotMap\Entity\Hotspot($this->user->id,'SAXO','Campus des Cézeaux, 63170 AUBIERE','16-03-2014');
        $this->hp2->hasCoffee = 1;
        $this->hp2->hasWifi = 1;
        $this->hp2->hasPlugs = 0;
    }

    public function testSave()
    {
        $this->assertTrue($this->hotspotRepo->save($this->hp1));
        $this->assertTrue($this->hotspotRepo->save($this->hp2));
    }

    public function testCount()
    {
        $this->assertEquals($this->hotspotRepo->count(), 2);
    }

    /**
     * @depends testCount
     */
    public function testDelete()
    {
        $this->assertTrue($this->hotspotRepo->delete(1));
    }
}
 