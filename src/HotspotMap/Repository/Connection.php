<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 14/02/2014
 * Time: 22:27
 */

namespace HotspotMap\Repository;


class Connection extends \PDO {

    /**
     * @param string $query
     * @param array $parameters
     * @return bool Returns `true` on success, `false` otherwise
     */
    public function executeQuery($query, array $parameters = [])
    {
        $stmt = $this->prepare($query);

        foreach ($parameters as $name => $value)
        {
            $stmt->bindValue(':' . $name, $value);
        }

        return $stmt->execute();
    }

    /**
     * @param string $query
     * @param array $parameters
     * @return array
     */
    public function executeFetchQuery($query, array $parameters = [])
    {
        $stmt = $this->prepare($query);

        foreach ($parameters as $name => $value)
        {
            $stmt->bindValue(':' . $name, $value);
        }

        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @param string $query
     * @param array $parameters
     * @return array
     */
    public function executeFetchAllQuery($query, array $parameters = [])
    {
        $stmt = $this->prepare($query);

        foreach ($parameters as $name => $value)
        {
            $stmt->bindValue(':' . $name, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }
} 