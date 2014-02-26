<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 14/02/2014
 * Time: 18:16
 */

namespace HotspotMap\Repository;


interface RepositoryInterface {

    public function save($entity);

    public function delete($id);

    public function count();

    public function find($id);

    public function findAll();
} 