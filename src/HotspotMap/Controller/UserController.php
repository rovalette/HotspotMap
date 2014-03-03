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

    protected function initConnection(Application $app)
    {
        $dsn = $app['db.options']['system'].':host='.$app['db.options']['host'].';dbname='.$app['db.options']['dbname'];

        $con = new Connection($dsn, $app['db.options']['user'], $app['db.options']['password']);
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

        $this->initConnection($app);

        if ($this->userRepository->findOneByUserName($username))
        {
            return $app['twig']->render('signupError.twig', array(
                'message' => 'This username is already used.',
            ));
        }

        if ($this->userRepository->findOneByEmail($email))
        {
            return $app['twig']->render('signupError.twig', array(
                'message' => 'This E-mail is already used.',
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
                'message' => 'An error occured during registration.',
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

        $this->initConnection($app);

        $user = $this->userRepository->findOneByEmail($email);

        if (!$user || !password_verify($password, $user->password))
        {
            return $app['twig']->render('loginError.twig', array(
                'message' => 'Warning ! Bad password or E-mail address.',
            ));
        }

        $app['session']->start();
        $app['session']->set('user', array(
            'username' => $user->userName,
            'id' => $user->id
        ));

        return $app['twig']->render('success.twig', array(
            'message' => 'Well done '.$user->userName.' ! You are successfully logged in !',
        ));
    }

    public function doLogout(Request $request, Application $app)
    {
        $app['session']->invalidate();
        return $app['twig']->render('success.twig', array(
            'message' => 'Well done ! You are successfully logged out !',
        ));
    }
} 