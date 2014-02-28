<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 26/02/2014
 * Time: 17:23
 */

namespace HotspotMap\Controller;


use HotspotMap\Entity\User;
use HotspotMap\Repository\UserRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Tests\Fixtures\Entity;

class UserController {

    /**
     * @var userRepository
     */
    protected $userRepository;

    public function __construct()
    {
        // TODO : userRepository = new UserRepository
    }

    public function createUserAction(Request $request, Application $app)
    {
        $firstname  = $request->get('firstname');
        $lastname   = $request->get('lastname');
        $username   = $request->get('username');
        $password   = $request->get('password');
        $password2  = $request->get('password2');
        $email      = $request->get('email');

        // TODO : checks

        $user = new User(
            $firstname,
            $lastname,
            $username,
            $password,
            $email
        );

        //$this->userRepository->save($user);

        return $app['twig']->render('accountCreated.twig', array(
            'username' => $username,
        ));
    }
} 