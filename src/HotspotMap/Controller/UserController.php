<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 26/02/2014
 * Time: 17:23
 */

namespace HotspotMap\Controller;


use HotspotMap\Repository\UserRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class UserController {

    /**
     * @var UserRepository
     */
    protected $repository;

    public function createUserAction(Request $request, Application $app)
    {

        return $app['twig']->render('accountCreated.twig', array(
            'username' => $request->get('username'),
        ));
    }
} 