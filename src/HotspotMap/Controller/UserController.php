<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 26/02/2014
 * Time: 17:23
 */

namespace HotspotMap\Controller;


use HotspotMap\Entity\User;
use HotspotMap\Repository\Connection;
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
        $dsn = 'mysql:host=localhost;dbname=hotspotmap';

        $con = new Connection($dsn, 'root', 'root');
        $this->userRepository = new UserRepository($con);
    }

    public function createUserAction(Request $request, Application $app)
    {
        $firstname  = $request->get('firstname');
        $lastname   = $request->get('lastname');
        $username   = $request->get('username');
        $password   = $request->get('password');
        $password2  = $request->get('password2');
        $email      = $request->get('email');

        if (empty($firstname) ||
            empty($lastname) ||
            empty($username) ||
            empty($password) ||
            empty($password2) ||
            empty($email) )
        {
            return $app['twig']->render('signupError.twig', array(
                'message' => 'Warning ! A field is empty.',
            ));
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return $app['twig']->render('signupError.twig', array(
                'message' => 'Warning ! Bad e-mail address.',
            ));
        }

        // PASSWORD_DEFAULT = blowfish with php 5.5.0
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        if (!password_verify($password2, $passwordHash))
        {
            return $app['twig']->render('signupError.twig', array(
                'message' => 'Warning ! The two passwords are differents.',
            ));
        }

        $user = new User(
            $firstname,
            $lastname,
            $username,
            $passwordHash,
            $email
        );

        if (!$this->userRepository->save($user))
        {
            return $app['twig']->render('signupError.twig', array(
                'message' => 'This username is already used.',
            ));
        }

        return $app['twig']->render('success.twig', array(
            'message' => 'Well done '.$username.' ! Your account has been created.',
        ));
    }

    public function doLogin(Request $request, Application $app)
    {
        $email      = $request->get('email');
        $password   = $request->get('password');

        if (empty($email) ||
            empty($password))
        {
            return $app['twig']->render('loginError.twig', array(
                'message' => 'Warning ! Please fill all fields.',
            ));
        }

        return $app['twig']->render('success.twig', array(
            'message' => 'In construction...',
        ));
    }
} 