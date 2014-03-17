<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 10/03/2014
 * Time: 18:58
 */

namespace HotspotMap\Repository;


use HotspotMap\Entity\Hotspot;

class HotspotRepository implements RepositoryInterface {

    /**
     * @var Connection
     */
    protected $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    /**
     * @param Hotspot $hotspot
     * @return bool Returns `true` on success, `false` otherwise
     */
    public function save($hotspot)
    {
        $query = 'INSERT INTO hotspots (userid,name,address,date,hasplugs,hascoffee,haswifi)
                VALUES (:userid,:name,:address,:date,:hasplugs,:hascoffee,:haswifi)';

        $result = $this->con->executeQuery($query, [
            'userid'    => $hotspot->userId,
            'name'      => $hotspot->name,
            'address'   => $hotspot->address,
            'date'      => $hotspot->date,
            'hasplugs'  => $hotspot->hasPlugs,
            'hascoffee' => $hotspot->hasCoffee,
            'haswifi'   => $hotspot->hasWifi,
        ]);

        $hotspot->id = $this->con->lastInsertId();

        return $result;
    }

    public function delete($id)
    {
        $query = 'DELETE FROM hotspots WHERE id = :id';

        return $this->con->executeQuery($query, [
            'id' => $id,
        ]);
    }

    public function count()
    {
        $query = 'SELECT COUNT(*) FROM hotspots';
        return $this->con->executeQuery($query);
    }

    public function find($id)
    {
        $query = 'SELECT * FROM hotspots WHERE id = :id';

        $result = $this->con->executeFetchQuery($query, [
            'id' => $id,
        ]);

        if (empty($result))
        {
            return null;
        }

        $hotspot = new Hotspot(
            $result['userid'],
            $result['name'],
            $result['address'],
            $result['date'],
            $result['id']
        );
        $hotspot->hasPlugs = $result['hasplugs'];
        $hotspot->hasCoffee = $result['hascoffee'];
        $hotspot->hasWifi = $result['haswifi'];

        return $hotspot;
    }

    public function findAll()
    {
        $query = 'SELECT * FROM hotspots';

        $result = $this->con->executeFetchAllQuery($query);

        if (empty($result))
        {
            return null;
        }

        $hotspots = array();

        foreach ($result as $value)
        {
            $hotspot = new Hotspot(
                $value['userid'],
                $value['name'],
                $value['address'],
                $value['date'],
                $value['id']
            );
            $hotspot->hasPlugs = $value['hasplugs'];
            $hotspot->hasCoffee = $value['hascoffee'];
            $hotspot->hasWifi = $value['haswifi'];

            array_push($hotspots, $hotspot);
        }

        return $hotspots;
    }
}