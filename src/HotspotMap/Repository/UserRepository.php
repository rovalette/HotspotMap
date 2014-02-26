<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 14/02/2014
 * Time: 18:27
 */

namespace HotspotMap\Repository;


use HotspotMap\Entity\User;

class UserRepository implements RepositoryInterface {

    /**
     * @var Connection
     */
    protected $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    /**
     * @param \HotspotMap\Entity\User $user
     * @return bool Returns `true` on success, `false` otherwise
     */
    public function save($user)
    {
        $query = 'INSERT INTO users (firstname,lastname,username,password,email)
                    VALUES (:firstname,:lastname,:username,:password,:email)';

        $result = $this->con->executeQuery($query, [
            'firstname' => $user->firstName,
            'lastname'  => $user->lastName,
            'username'  => $user->userName,
            'password'  => $user->password,
            'email'     => $user->email,
        ]);

        $user->id = $this->con->lastInsertId();

        return $result;
    }

    public function delete($id)
    {
        $query = 'DELETE FROM users WHERE id = :id';

        return $this->con->executeQuery($query, [
           'id' => $id,
        ]);
    }

    public function count()
    {
        $query = 'SELECT COUNT(*) FROM users';
        return $this->con->executeQuery($query);
    }

    /**
     * @param integer $id
     * @return User|null
     */
    public function find($id)
    {
        $query = 'SELECT * FROM users WHERE id = :id';

        $result = $this->con->executeFetchQuery($query, [
           'id' => $id,
        ]);

        if (empty($result))
        {
            return null;
        }

        $user = new User(
            $result['firstname'],
            $result['lastname'],
            $result['username'],
            $result['password'],
            $result['email'],
            $result['id']);

        return $user;
    }

    /**
     * @return array|null
     */
    public function findAll()
    {
        $query = 'SELECT * FROM users';

        $result = $this->con->executeFetchAllQuery($query);

        if (empty($result))
        {
            return null;
        }

        $users = array();

        foreach ($result as $value)
        {
            $user = new User(
                $value['firstname'],
                $value['lastname'],
                $value['username'],
                $value['password'],
                $value['email'],
                $value['id']);

            array_push($users, $user);
        }

        return $users;
    }
}